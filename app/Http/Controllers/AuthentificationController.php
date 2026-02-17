<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthentificationController extends Controller
{
    //
    public function index(){
        return view('auth.login');
    }

    public function login(){}
    public function logout(){}

}
