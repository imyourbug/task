<?php

use App\Http\Controllers\Admin\Accounts\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'App\Http\Controllers\Users'], function () {
    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
        Route::post('/updateElecTask', 'TaskController@updateElecTask')->name('updateElecTask');
        Route::post('/updateWaterTask', 'TaskController@updateWaterTask')->name('updateWaterTask');
        Route::post('/updateAirTask', 'TaskController@updateAirTask')->name('updateAirTask');
        Route::post('export', 'TaskController@export')->name('export');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Admin'], function () {
    Route::group(['namespace' => 'Accounts', 'prefix' => 'accounts', 'as' => 'accounts.'], function () {
        Route::delete('/{id}/destroy', 'AccountController@destroy')->name('destroy');
    });
    Route::group(['namespace' => 'Customers', 'prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::delete('/{id}/destroy', 'CustomerController@destroy')->name('destroy');
    });

    Route::group(['namespace' => 'TaskTypes', 'prefix' => 'tasktypes', 'as' => 'tasktypes.'], function () {
        Route::delete('/{id}/destroy', 'TaskTypeController@destroy')->name('destroy');
    });

    #contracts
    Route::group(['namespace' => 'Contracts', 'prefix' => 'contracts', 'as' => 'contracts.'], function () {
        Route::post('/create', 'ContractController@store')->name('store');
        Route::delete('/{id}/destroy', 'ContractController@destroy')->name('destroy');
    });

    #staffs
    Route::group(['namespace' => 'Staffs', 'prefix' => 'staffs', 'as' => 'staffs.'], function () {
        Route::delete('/{id}/destroy', 'InfoUserController@destroy')->name('destroy');
    });

    #airtasks
    Route::group(['prefix' => 'airtasks', 'namespace' => 'AirTasks', 'as' => 'airtasks.'], function () {
        Route::delete('/{id}/destroy', 'AirTaskController@destroy')->name('destroy');
    });

    #watertasks
    Route::group(['prefix' => 'watertasks', 'namespace' => 'WaterTasks', 'as' => 'watertasks.'], function () {
        Route::delete('/{id}/destroy', 'WaterTaskController@destroy')->name('destroy');
    });

    #electasks
    Route::group(['prefix' => 'electasks', 'namespace' => 'ElecTasks', 'as' => 'electasks.'], function () {
        Route::delete('/{id}/destroy', 'ElecTaskController@destroy')->name('destroy');
    });
});

// Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
//     Route::delete('/{id}/destroy', [AccountController::class, 'destroy'])->name('destroy');
// });
