<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Main_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoryController extends Controller
{
    public function index(){
        $default_lang = get_default_lang();
        $main_categories = Main_category::where('translation_lang', $default_lang)->selection()->get();
        return view('admin.maincategories.index',['main_categories' => $main_categories]);
    }

    public function create(){
        return view('admin.maincategories.create');
    }

    public function store(MainCategoryRequest $request){

       try {
            // All Categories Convert To Collection
            $main_categories = collect($request->category);

            // Filter All Categories To Define The Default Category
            $filter = $main_categories->filter(function($value, $key){
                        return $value['abbr'] == get_default_lang();
            });
            $default_category = array_values($filter->all())[0];

            // Check If There Photo And Save It And Return The path
            $file_path = "";
            if($request->hasFile('photo')){
                $file_path = uploadImage('maincategories', $request->photo);
            }


            DB::beginTransaction();

            // Insert Data In The DB And Return The ID Of It
            $default_category_id =Main_category::insertGetId([
                'translation_lang' =>$default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'photo' => $file_path,
            ]);


            // Filter All Categories Except The Default Category
            $categories = $main_categories->filter(function($value, $key){
                return $value['abbr'] != get_default_lang();
            });

            // Check If There Are Other Categories And Store In the Array
            if(isset($categories) && $categories->count() > 0 ){
                $categories_arr = [];
                foreach ($categories as $category) {
                    $categories_arr[] = [
                        'translation_lang' =>$category['abbr'],
                        'translation_of' => $default_category_id,
                        'name' => $category['name'],
                        'slug' => $category['name'],
                        'photo' => $file_path,
                    ];
                }

                // Insert The Array In The main_categories Table
                Main_category::insert($categories_arr);
            }

            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم الحفظ بنجاح']);



       } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطأ ما يرجي المحاولة لاحقا']);
       }
    }

    public function edit($mainCatId){
        $mainCategory = Main_category::selection()->find($mainCatId);
        if(!$mainCategory){
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);
        }

        return view('admin.maincategories.edit')->with('mainCategory', $mainCategory);
    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }
}
