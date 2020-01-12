<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\User;

use App\Http\Controllers\Controller;


class LoginController extends Controller
{

    public function __construct(){

        $this->middleware('guest' ,['only' => 'showLoginForm' ]);
    }

    public function showLoginForm(){
        return view('login.login');
    }

    public function login(){

    

        $credentials =$this->validate(request(),[
                'nombre' => 'required|string',
                'password' => 'required|string'
            ]
        );

        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard');
        }else{
            return back()->withErrors(['nombre' => trans('auth.failed')])->withInput(request(['nombre']));
        }
        
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
