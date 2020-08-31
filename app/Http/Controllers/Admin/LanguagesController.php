<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function index(){
        $langs = Language::select()->paginate(PAGINATION_COUNT);
        return view('admin.languages.index',['langs' => $langs]);
    }

    public function create(){
        return view('admin.languages.create');
    }

    public function store(LanguageRequest $request){
        try {
            Language::create($request->except('_token'));
            return redirect()->route('admin.languages')->with(['success'=> 'تم حفظ اللغة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطأ ما يرجى اعادة المحاولة']);
        }
    }

    public function edit($id){
       $language = Language::select()->find($id);
       if(! $language){
           return redirect()->route('admin.languages')->with(['error' => 'هذه اللغة غير موجودة']);
       }else{
           return view('admin.languages.edit')->with('lang', $language);
       }
    }

    public function update(LanguageRequest $request, $id){
        try {
            $language = Language::find($id);
            if(! $language){
                return redirect()->route('admin.languages.edit', $id)->with(['error' => 'هذه اللغة غير موجودة']);
            }else{
                if(!$request->has('active')){
                    $request->request->add(['active'=> 0]);
                }
                $language->update($request->except('_token'));
                return redirect()->route('admin.languages')->with(['success' => 'تم تحديث اللغة بنجاح']);
            }
        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطأ ما يرجى اعادة المحاولة']);
        }
    }

    public function destroy($id){
        try {
            $language = Language::find($id);
            if(! $language){
                return redirect()->route('admin.languages')->with(['error' => 'هذه اللغة غير موجودة']);
            }else{
                $language->delete();
                return redirect()->route('admin.languages')->with(['success' => 'تم حذف اللغة بنجاح']);
            }
        } catch (\Exception $ex) {
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطأ ما يرجى اعادة المحاولة']);
        }
    }
}
