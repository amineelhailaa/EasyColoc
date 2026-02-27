<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthentificationController extends Controller
{
    //
    public function index(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password,'ban'=>0], $request->remember())){
            return back()->withErrors(['email'=>'verify emailor pass and try again ']);
        }
        $request->session()->regenerate();
        if(auth()->user()->role === 'admin'){
            return redirect()->route('admin.dashboard');
        }
        return redirect()->intended(route('home'));
    }


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
