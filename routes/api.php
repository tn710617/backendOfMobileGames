<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/paymentResponse', 'PaymentsController@paymentResponse');
Route::post('/register', 'ApiRegistrationController@register')->middleware('content_length');
Route::post('/login', 'ApiLoginController@login')->middleware('content_length');

Route::middleware(['content_length', 'tokenValidator'])->group(function (){
    Route::get('/profile/{game}', 'ApiSessionsController@show');
    Route::get('/achievements/{game}', 'AchievementController@show');
    Route::get('/items/{game}', 'ItemController@show');
    Route::get('/common-achievements', 'CommonAchievementController@show');
    Route::post('/achievements/{achievement}', 'achievedController@achieve');
    Route::post('/items/{item}', 'PurchasedController@purchased');
    Route::put('/items/{item}', 'PurchasedController@use');
    Route::get('/possessions/{game}', 'PurchasedController@possessions');
    Route::patch('/remaining-points/{game}', 'GameController@play');
    Route::get('/accomplished-achievements/{game}', 'AchievedController@showAchieved');
});
