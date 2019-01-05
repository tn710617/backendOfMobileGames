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
Route::post('/profile', 'ApiSessionsController@show')->middleware('content_length')->middleware('tokenValidator');
Route::post('/register', 'ApiRegistrationController@register')->middleware('content_length');
Route::post('/login', 'ApiLoginController@login')->middleware('content_length');
Route::get('/achievements/{game}', 'AchievementController@show')->where('game', '[0-9]+')->middleware('content_length')->middleware('tokenValidator');
Route::get('/items/{game}', 'ItemController@show')->where('game', '[0-9]+')->middleware('content_length')->middleware('tokenValidator');
Route::post('/getCommonAchievementList', 'CommonAchievementController@show')->middleware('content_length')->middleware('tokenValidator');
Route::post('/achievements/{achievement}', 'achievedController@achieve')->where('achievement', '[0-9]+')->middleware('content_length')->middleware('tokenValidator');
Route::post('/items/{item}', 'PurchasedController@purchased')->where('item', '[0-9]+')->middleware('content_length')->middleware('tokenValidator');
Route::put('/items/{item}', 'PurchasedController@use')->where('item', '[0-9]+')->middleware('content_length')->middleware('tokenValidator');
Route::post('/possessions', 'PurchasedController@possessions')->middleware('content_length')->middleware('tokenValidator');
Route::post('/play', 'GameController@play')->middleware('content_length')->middleware('tokenValidator');
Route::post('/showAchieved', 'AchievedController@showAchieved')->middleware('content_length')->middleware('tokenValidator');
Route::post('/test', 'CommonlyAchievedController@test')->middleware('content_length')->middleware('tokenValidator');

