<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) {

        //get authenticated user
        $user = $request->user();
        return view('home');
    }
}