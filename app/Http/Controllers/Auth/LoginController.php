<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{

    public function __construct(){

        $this->middleware('guest' ,['only' => 'showLoginForm' ]);
    }

    public function showLoginForm(){
        return view('login.login');
    }

    public function login(LoginRequest $request){

        $credentials = $request->validated();

        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard');
        }else{
            return back()->withErrors([$this->username() => trans('auth.failed')])->withInput(request([$this->username()]));
        }
        
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function username(){
        return 'email';
    }
}
