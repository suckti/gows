<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'password' => 'required',
                'name' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }

        try {
            $user = new User();
            $user->email = $request->input('email');
            $user->name = $request->input('name');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return response()->json([
                'message' => 'Register Success',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid login detail!',
            ], 401);
        }
        // $credentials = $request->only('email', 'password');
        // if (Auth::attempt($credentials)){
        //     return response()->json([
        //         'message' => 'sakses',
        //     ], 200);
        // }
        $token = $user->createToken('iphone11')->plainTextToken;
        return response()->json([
            'message' => 'Successfully login',
            'data' => [
                'access_token' => $token
            ]
        ], 200);
    }

    public function checkUser(Request $request) {
        echo 'test';exit();
        print_r($request->user());
    }
}
