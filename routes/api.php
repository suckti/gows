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

Route::middleware(['auth:sanctum', 'api'])->group(function () {
    Route::get('profile', 'HomeController@profile');
    Route::post('activity', 'StravaController@saveActivity');

    //Challenge
    Route::post('challenge', 'ChallengeController@save');
    Route::put('challenge/{id}', 'ChallengeController@edit');
    Route::delete('challenge/{id}', 'ChallengeController@delete');
    Route::get('challenge/{id}', 'ChallengeController@detail');
    Route::get('challenge', 'ChallengeController@list');
    Route::post('challenge/athlete/add', 'ChallengeController@athleteAdd');
    Route::delete('challenge/athlete/delete', 'ChallengeController@athleteDelete');

    //Group
    Route::post('challenge/group', 'ChallengeGroupController@save');
    Route::put('challenge/group/{id}', 'ChallengeGroupController@edit');
    Route::delete('challenge/group/{id}', 'ChallengeGroupController@delete');
    Route::get('challenge/group/{id}', 'ChallengeGroupController@detail');
    Route::get('challenge/group-list/{challengeId}', 'ChallengeGroupController@list');
    Route::get('challenge/group/generate-random-athlete/{challengeId}', 'ChallengeGroupController@generateRandomAthlete');

    Route::post('challenge/group/athlete-add', 'ChallengeGroupController@athleteAdd');
    Route::post('challenge/group/athlete-delete', 'ChallengeGroupController@athleteDelete');
    Route::get('challenge/group/athlete-list/{challengeId}', 'ChallengeGroupController@athleteListByChallenge');
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
