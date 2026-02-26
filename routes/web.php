<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SplitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\OwnerController;
Route::view('/', 'main')->name('main');


//Route::get('/login', function () {
//    return view('auth.login');
//})->name('login');
//Route::get('/register', function () {
//    return view('auth.register');
//})->name('register');




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


//no membership roles
Route::middleware('notMember')->group(function () {
    Route::view('/home','welcome')->name('home');
    Route::resource('colocation', ColocationController::class)->only(['store','create','index']);



    //invitation
    Route::get('/invitation/link/{token}',[InvitationController::class,'show'])->name('invitation.show');
    Route::post('/invitation/accept',[InvitationController::class,'accept'])->name('invitation.accept');
    Route::post('/invitation/decline',[InvitationController::class,'decline'])->name('invitation.decline');

});





Route::middleware('auth')->group(function (){
    Route::post('/logout', [AuthentificationController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.view');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/pwd', [ProfileController::class, 'updatePassword'])->name('profile.password');

    //create colocation
    });










//member
Route::middleware('membership.role:member')->group(function () {
//    Route::resource('colocation', ColocationController::class)->only('index');
    Route::get('/member/dashboard',[MemberController::class,'index'])->name('member.dashboard');
});

//owner
Route::middleware('membership.role:owner')->group(function () {
    Route::get('/owner/dashboard',[OwnerController::class, 'index'])->name('owner.dashboard');

    //invitation
    Route::post('/invitation/send',[InvitationController::class,'store'])->name('invitation.send');


    //categories
    Route::post('/owner/category',[OwnerController::class,'store'])->name('owner.category.add');
    Route::delete('/owner/category/{category}',[OwnerController::class,'destroy'])->name('owner.category.delete');
});




//member and owner

Route::middleware('membership.role:owner,member')->group(function () {
    // aa expense
    Route::post('/expense/add',[\App\Http\Controllers\ExpenseController::class,'store'])->name('expense.add');
//    Route::resource('colocation', ColocationController::class)->except(['store','index','create']);


    //markaspaid
    Route::patch('/split/paid',[SplitController::class,'marquerPayee'])->name('split.paid');
});


//admin
Route::middleware('admin')->group(function () {

});
