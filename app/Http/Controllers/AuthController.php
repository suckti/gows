<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $stravaOauth = 'https://www.strava.com/oauth/authorize';
        //add query string client_id, redirect_uri, response_type, scope
        $stravaOauth .= '?client_id=' . env('STRAVA_CLIENT_ID');
        $stravaOauth .= '&redirect_uri=' . env('APP_URL') . '/exchange-token';
        $stravaOauth .= '&approval_prompt=auto';
        $stravaOauth .= '&response_type=code';
        $stravaOauth .= '&scope=activity:read';

        return view('auth/login', ['stravaOauth' => $stravaOauth]);
    }

    public function loginByStrava(Request $request)
    {
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect('/set-password')
                ->withErrors($validator)
                ->withInput();
        }

        //attempt password

        //redirect to home
        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        //redirect to login
        return redirect('/login');
    }
}
