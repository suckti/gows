<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/verification-email/{token}', 'HomeController@verifyEmail')->name('verification-email');
Route::get('/password-reset/{token}', 'HomeController@passwordReset')->name('password-reset');
Route::post('/password-reset', 'HomeController@passwordResetSubmit');
Route::get('/exchange-token/{id}', 'StravaController@exchangeToken');