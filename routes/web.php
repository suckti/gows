<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StravaController;
use App\Http\Controllers\HomeController;
use App\Livewire\SetPassword;

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
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-by-strava', [AuthController::class, 'loginByStrava'])->name('login-by-strava');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/verification-email/{token}', [HomeController::class, 'verifyEmail'])->name('verification-email');
Route::get('/password-reset/{token}', [HomeController::class, 'passwordReset'])->name('password-reset');
Route::post('/password-reset', [HomeController::class, 'passwordResetSubmit']);
Route::get('/exchange-token', [StravaController::class, 'exchangeToken']);
Route::get('/strava-webhook', [StravaController::class, 'webhookValidation']);
Route::post('/strava-webhook', [StravaController::class, 'webhookEvent']);

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/set-password', SetPassword::class)->name('set-password');