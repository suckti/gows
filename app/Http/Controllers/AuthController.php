<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        //check if user is logged in
        if ($request->user()) {
            return redirect('/dashboard');
        }

        return view('auth/login', ['stravaOauth' => $stravaOauth]);
    }

    public function loginSubmit(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator)
                ->withInput();
        }

        $rememberMe = $request->get('remember') ? true : false;
        //attempt login
        if (Auth::attempt(['username' => $request->get('username'), 'password' => $request->get('password')], $rememberMe)) {
            if (Auth::user()->strava_athlete_id == $request->get('password')) {
                return redirect()->route('set-password');
            }

            return redirect('/dashboard');
        }

        return redirect('/login')
            ->withErrors(['username' => 'Invalid username or password'])
            ->withInput();
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
        Auth::logout();
        return redirect('/login');
    }
}
