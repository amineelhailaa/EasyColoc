<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

      $user =  User::create([
            'name' => $request->fullName,
            'email' => $request->email,
            'password'=>Hash::make($request->password),
            'avatar' => $avatarPath,
        ]);
    Auth::login($user);
    return redirect()->route('login');
    }
}
