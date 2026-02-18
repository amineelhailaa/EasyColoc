<?php

use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\RegisterController;
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/', function () {
   return view('welcome');
})->name('register');


Route::middleware('guest')->group(function () {

    //login
    Route::get('/login', [AuthentificationController::class,'index'])->name('login');
    Route::post('/login',[ AuthentificationController::class,'login']);
    //signup
    Route::get('/register', [RegisterController::class,'index'])->name('register');
    Route::post('/register',[ RegisterController::class,'register']);
    //forget password
    Route::get('/reset_password', [ResetPasswordController::class,'index'])->name('reset_password');
});
