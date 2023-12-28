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
    Route::get('/task', 'TaskController@getQuantityByType');
    Route::post('/getOTP', 'TaskController@getOTP');
    Route::post('/updateOTP', 'TaskController@updateOTP');
    Route::get('/getNumberphone', 'TaskController@getNumberphone');
});

Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
    Route::delete('/{id}/destroy', [AccountController::class, 'destroy'])->name('destroy');
});


