<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});



Route::group(['namespace' => 'Admin\v1','prefix'=>'admin', 'middleware'=>['preventBackHistory','loginAuth']], function () {

    /**********Auth Functionality***********/
    Route::match(['get','post'],'/','AuthController@login');
    Route::match(['get','post'],'/login','AuthController@login');
    Route::match(['get','post'],'/forgot-password','AuthController@forgotPassword');
    Route::match(['get','post'],'/verify-otp','AuthController@verifyOtp');
    Route::match(['get','post'],'/change-password','AuthController@changePassword');
    
    Route::match(['get','post'],'/resend-otp','AuthController@resendOtp');
});


Route::group(['namespace' => 'Admin\v1','prefix'=>'admin', 'middleware'=>['preventBackHistory','afterLoginAuth']], function () {
    
    Route::match(['get','post'],'/logout','AuthController@logout');
    Route::match(['get','post'],'/dashboard','AdminController@dashboard');
    Route::match(['get','post'],'/update-password','AuthController@updatePassword');

    // Hotel Management
    Route::match(['get','post'],'/manage-hotel','HotelController@index');
    Route::match(['get','post'],'/manage-hotel/view/{id}','HotelController@view');
    Route::match(['get','post'],'/manage-hotel/delete/{id}','HotelController@deletehotel');
    Route::match(['get','post'],'/manage-hotel/deactivate/{id}','HotelController@deactivate');
    Route::match(['get','post'],'/manage-hotel/delete','HotelController@deleted');
    Route::match(['get','post'],'/manage-hotel/search','HotelController@search');

    // Setting Management
    Route::match(['get','post'],'/setting','SettingController@index');
    Route::match(['get','post'],'/setting/update','SettingController@update');

    // Tutorial Management
    Route::match(['get','post'],'/manage-tutorial','TutorialController@index');
    Route::match(['get','post'],'/manage-tutorial/add','TutorialController@add');
    Route::match(['get','post'],'/manage-tutorial/delete','TutorialController@delete');

    // Transaction Management
    Route::match(['get','post'],'/transaction-history','TransactionController@index');
    Route::match(['get','post'],'/transaction-history/download','TransactionController@download');
    Route::match(['get','post'],'/transaction-history/list','TransactionController@list');
    


});

