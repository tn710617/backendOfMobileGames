<?php

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

Route::get('/payments', 'PaymentsController@paymentShow');
Route::post('/payments', 'PaymentsController@paymentConnect');

Route::post('/register', 'RegistrationsController@register');
Route::get('/register', 'RegistrationsController@show')->name('register');
Route::get('/login', 'SessionsController@show')->name('login');
Route::post('/login', 'SessionsController@store');
Route::get('/', 'SessionsController@index')->name('home');
Route::get('/logout', 'SessionsController@destroy');
Route::get('/orders', 'PaymentsController@showOrders');

