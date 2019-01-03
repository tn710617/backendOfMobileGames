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
Route::post('/getAchievementList', 'AchievementController@show')->middleware('content_length')->middleware('tokenValidator');
Route::post('/getItemList', 'ItemController@show')->middleware('content_length')->middleware('tokenValidator');
Route::post('/getCommonAchievementList', 'CommonAchievementController@show')->middleware('content_length')->middleware('tokenValidator');
Route::post('/achieve', 'achievedController@achieve')->middleware('content_length')->middleware('tokenValidator');
Route::post('/purchase', 'PurchasedController@purchased')->middleware('content_length')->middleware('tokenValidator');
Route::post('/use', 'PurchasedController@use')->middleware('content_length')->middleware('tokenValidator');
Route::post('/possessions', 'PurchasedController@possessions')->middleware('content_length')->middleware('tokenValidator');
Route::post('/play', 'GameController@play')->middleware('content_length')->middleware('tokenValidator');
Route::post('/showAchieved', 'AchievedController@showAchieved')->middleware('content_length')->middleware('tokenValidator');
Route::post('/test', 'CommonlyAchievedController@test')->middleware('content_length')->middleware('tokenValidator');

