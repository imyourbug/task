<?php

use App\Http\Controllers\Users\TaskController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function() {
    return view('user.login.index', [
        'title' => 'Đăng nhập'
    ]);
});

#user
Route::group(['prefix' => 'user', 'namespace' => 'App\Http\Controllers\Users', 'as' => 'users.'], function () {
    Route::get('/', 'UserController@index')->name('home')->middleware('auth');
    Route::get('login', 'UserController@login')->name('login');
    Route::get('forgot', 'UserController@forgot')->name('forgot');
    Route::post('recover', 'UserController@recover')->name('recover');
    Route::post('login', 'UserController@checkLogin')->name('checkLogin');
    Route::get('register', 'UserController@register')->name('register');
    Route::post('register', 'UserController@checkRegister')->name('checkRegister');
    Route::post('change_password', 'UserController@changePassword')->name('changePassword');
    Route::get('logout', 'UserController@logout')->name('logout');

    #task
    Route::group(['prefix' => 'task', 'as' => 'task.', 'middleware' => 'auth' ], function () {

        Route::get('/', 'TaskController@index')->name('index');
        Route::post('/download', 'TaskController@download')->name('download');
        Route::get('/complete/{id}', 'TaskController@update')->name('update');
        Route::get('/delete/{id}', 'TaskController@destroy')->name('destroy');
        Route::get('/display/{id}', 'TaskController@display')->name('display');
    });
    #upload
    Route::post('/upload-excel', 'UploadController@upload')->name('upload')->middleware('auth');
});

#admin
Route::group(['prefix' => '/admin', 'namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::get('/', 'AdminController@index')->name('index');
    #accounts
    Route::group(['prefix' => 'accounts', 'namespace' => 'Accounts', 'as' => 'accounts.'], function () {
        Route::get('/', 'AccountController@index')->name('index');
        Route::get('/create', 'AccountController@create')->name('create');
        Route::post('/create', 'AccountController@store')->name('store');
        Route::get('/update/{id}', 'AccountController@show')->name('show');
        Route::post('/update', 'AccountController@update')->name('update');
        Route::get('/delete/{id}', 'AccountController@delete')->name('delete');
    });
    #volunteers
    Route::group(['prefix' => 'volunteers', 'namespace' => 'Volunteers', 'as' => 'volunteers.'], function () {
        Route::get('/', 'VolunteerController@index')->name('index');
        Route::get('/request', 'VolunteerController@request')->name('request');
        Route::get('/getData', 'VolunteerController@getData')->name('getData');
        Route::get('/getDataById/{id}', 'VolunteerController@getDataById');
    });
});
