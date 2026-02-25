<?php

use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;


//Route::get('/login', function () {
//    return view('auth.login');
//})->name('login');
//Route::get('/register', function () {
//    return view('auth.register');
//})->name('register');

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware('guest')->group(function () {
    //login
    Route::get('/login', [AuthentificationController::class, 'index'])->name('login');
    Route::post('/login', [AuthentificationController::class, 'login']);
    //signup
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'create']);
    //forget password
    Route::get('/reset_password', [ResetPasswordController::class, 'index'])->name('reset_password');
    Route::post('/reset_email_sent', [ResetPasswordController::class, 'resetPassword'])->name('reset_email_sent');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});



Route::view('/test', 'globalDashboard');


Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthentificationController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.view');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/pwd', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::resource('colocation', ColocationController::class);
});

Route::get('/owner/dashboard',[\App\Http\Controllers\OwnerController::class, 'index'])->name('owner.dashboard');



//expense
Route::post('/expense/add',[\App\Http\Controllers\ExpenseController::class,'store'])->name('expense.add');
