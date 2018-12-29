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
Route::post('/profile', 'ApiSessionsController@show')->middleware('tokenValidator')->middleware('content_length');
Route::post('/findTheLittleMan', 'MutualAccomplishmentController@findTheLittleMan')->middleware('tokenValidator')->middleware('content_length');
Route::post('/profile', 'ApiSessionsController@show')->middleware('tokenValidator')->middleware('content_length');
Route::post('/deduction', 'PaymentDetailController@deduct')->middleware('tokenValidator')->middleware('content_length');
Route::post('/personalAccomplishment', 'MutualAccomplishmentController@personalAccomplishment')->middleware('tokenValidator')->middleware('content_length');
Route::post('/items', 'ShopController@show')->middleware('tokenValidator')->middleware('content_length');
Route::post('/purchase', 'ShopController@update')->middleware('tokenValidator')->middleware('content_length');
Route::post('/getAchievementList', 'AchievementController@show')->middleware('content_length');
Route::post('/getItemList', 'ItemController@show')->middleware('content_length');
Route::post('/achieved', 'achievedController@achieved')->middleware('content_length')->middleware('tokenValidator');
Route::post('/purchased', 'PurchasedController@purchased')->middleware('content_length')->middleware('tokenValidator');
Route::post('/use', 'PurchasedController@use')->middleware('content_length')->middleware('tokenValidator');
Route::post('/possessions', 'PurchasedController@possessions')->middleware('content_length')->middleware('tokenValidator');

