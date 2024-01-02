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

Route::get('/', function () {
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
    Route::group(['prefix' => 'task', 'as' => 'task.', 'middleware' => 'auth'], function () {
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
    });

    #customers
    Route::group(['prefix' => 'customers', 'namespace' => 'Customers', 'as' => 'customers.'], function () {
        Route::get('/', 'CustomerController@index')->name('index');
        Route::get('/create', 'CustomerController@create')->name('create');
        Route::post('/create', 'CustomerController@store')->name('store');
        Route::get('/update/{id}', 'CustomerController@show')->name('show');
        Route::post('/update', 'CustomerController@update')->name('update');
    });

    #staffs
    Route::group(['prefix' => 'staffs', 'namespace' => 'Staffs', 'as' => 'staffs.'], function () {
        Route::get('/', 'InfoUserController@index')->name('index');
        // Route::get('/create', 'InfoUserController@create')->name('create');
        // Route::post('/create', 'InfoUserController@store')->name('store');
        Route::get('/update/{id}', 'InfoUserController@show')->name('show');
        Route::post('/update', 'InfoUserController@update')->name('update');
    });

    #tasktypes
    Route::group(['prefix' => 'tasktypes', 'namespace' => 'TaskTypes', 'as' => 'tasktypes.'], function () {
        Route::get('/', 'TaskTypeController@index')->name('index');
        Route::get('/create', 'TaskTypeController@create')->name('create');
        Route::post('/create', 'TaskTypeController@store')->name('store');
        Route::get('/update/{id}', 'TaskTypeController@show')->name('show');
        Route::post('/update', 'TaskTypeController@update')->name('update');
    });

    #contracts
    Route::group(['prefix' => 'contracts', 'namespace' => 'Contracts', 'as' => 'contracts.'], function () {
        Route::get('/', 'ContractController@index')->name('index');
        Route::get('/create', 'ContractController@create')->name('create');
        Route::get('/update/{id}', 'ContractController@show')->name('show');
        Route::post('/update', 'ContractController@update')->name('update');
    });

    #electasks
    Route::group(['prefix' => 'electasks', 'namespace' => 'ElecTasks', 'as' => 'electasks.'], function () {
        Route::get('/', 'ElecTaskController@index')->name('index');
        Route::get('/create', 'ElecTaskController@create')->name('create');
        Route::post('/create', 'ElecTaskController@store')->name('store');
        Route::get('/update/{id}', 'ElecTaskController@show')->name('show');
        Route::post('/update', 'ElecTaskController@update')->name('update');
    });

    #airtasks
    Route::group(['prefix' => 'airtasks', 'namespace' => 'AirTasks', 'as' => 'airtasks.'], function () {
        Route::get('/', 'AirTaskController@index')->name('index');
        Route::get('/create', 'AirTaskController@create')->name('create');
        Route::post('/create', 'AirTaskController@store')->name('store');
        Route::get('/update/{id}', 'AirTaskController@show')->name('show');
        Route::post('/update', 'AirTaskController@update')->name('update');
    });

    #watertasks
    Route::group(['prefix' => 'watertasks', 'namespace' => 'WaterTasks', 'as' => 'watertasks.'], function () {
        Route::get('/', 'WaterTaskController@index')->name('index');
        Route::get('/create', 'WaterTaskController@create')->name('create');
        Route::post('/create', 'WaterTaskController@store')->name('store');
        Route::get('/update/{id}', 'WaterTaskController@show')->name('show');
        Route::post('/update', 'WaterTaskController@update')->name('update');
    });
});
