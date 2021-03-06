<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@store');
Route::post('access_level', 'UserController@accessLevel');

// Password reset
Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Api\ResetPasswordController@reset');

// Email Verification
Route::get('email/verify/{id}', 'Api\VerificationApiController@verify')->name('verification.verify');
Route::get('email/resend', 'Api\VerificationApiController@resend')->name('verification.resend');




Route::group(['middleware' => 'check.token', 'auth:api'], function () {
    Route::resource('users', 'UserController');
    Route::resource('customers', 'CustomerController');  
    Route::resource('invoices', 'InvoiceController');  

    Route::post('logout', 'UserController@logout');

    Route::get('generate_invoice_num', 'InvoiceController@generateInvoiceNumber');

});





