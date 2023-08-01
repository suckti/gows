<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request) {
        //check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('home');
    }
}