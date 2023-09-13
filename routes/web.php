<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::controller(UserController::class)->prefix('user')->group(function (){
    Route::get('/','register')->name('register.show');
    Route::get('verify/email/account/{email}', 'verifyEmailUserAccount')->name("EmailUser.verify");
    Route::post('register/store','userStore')->name('registerStore.save');
    Route::get('login','login')->name('login');
    Route::get('reset/password/start','resetPasswordStart')->name('resetPassword.start');
    Route::post('reset/password/verify/{email}','verifyEmailPasswordReset')->name('resetPasswordEmail.verify');
    Route::get('reset/password/end','resetPaswordFinish')->name('resetPassword.modify');
    Route::post('reset/password/store','resetPasswordStore')->name('resetPassword.save');
    Route::post('sign/in','signIn')->name('signIn');
});

Route::controller(CustomerController::class)->middleware('auth')->group(function(){
    Route::get('/','showCustomerList')->name('customer.show');
});

