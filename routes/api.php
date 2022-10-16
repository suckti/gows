<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
Route::middleware(['auth:sanctum', 'api'])->group(function(){
    Route::get('profile', 'HomeController@profile');
    Route::post('activity', 'StravaController@saveActivity');

    //Challenge
    Route::post('challenge', 'ChallengeController@save');
    Route::put('challenge/{id}', 'ChallengeController@edit');
    Route::delete('challenge/{id}', 'ChallengeController@delete');
    Route::get('challenge/{id}', 'ChallengeController@detail');
    Route::post('challenge/athlete/{id}', 'ChallengeController@athleteAdd');
    Route::post('challenge/athlete/request/{id}', 'ChallengeController@athleteRequest');
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout')->middleware('auth:sanctum');
    Route::post('forgot-password', 'AuthController@forgotPassword');
});

// Route::prefix('auth')->group(function(){
//     Route::post('register', function() {
//         return 'test';
//     });
// });

