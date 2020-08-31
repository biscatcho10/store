<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin(){
        return view('admin.Auth.login');
    }

    public function login(LoginRequest $request){
        $remember_me = $request->has('remember_me') ? true : false ;
        if(Auth::guard('admin')->attempt(['email' => $request->email , 'password' => $request->password]) ){
            // notify()->success('تم الدخول بنجاح');
            return redirect()->route('admin.dashboard');
        }else{
            // notify()->error('خطأ في البيانات يرجى المحالة مجددا');
            return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);
        }
    }
}
