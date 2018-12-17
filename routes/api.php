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

Route::get('/payments', 'PaymentsController@paymentConnect');

Route::post('/register', 'RegistrationsController@register');
Route::get('/register', 'RegistrationsController@show');
Route::get('/login', 'SessionsController@show');
Route::post('/login', 'SessionsController@store');
Route::post('/login', 'SessionsController@store');

