<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index(){
        return view('auth.register');
    }

    public function create(RegisterFormRequest $request){
      $user =  User::create([
            'name' => $request->fullname,
            'email' => $request->email,
            'password'=>Hash::make($request->password)
        ]);
    Auth::login($user);
    return redirect()->route('home');
    }
}
