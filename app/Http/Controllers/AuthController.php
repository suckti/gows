<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        //add checking numeric in name
        if (preg_match('~[0-9]+~', $request->input('name'))) {
            return response()->json([
                'message' => 'Please enter a valid name. Name can\'t contain numbers.',
            ], 400);
        }

        try {
            $token = base64_encode($request->input('email') . '#' . Str::random(12) . time());
            $user = new User();
            $user->email = $request->input('email');
            $user->name = $request->input('name');
            $user->password = Hash::make($request->input('password'));
            $user->verification_token = $token;
            $user->verification_token_expired = date('Y-m-d H:i:s', time() + (1 * 60 * 60));
            $user->save();

            Mail::to($request->input('email'))->send(new VerificationEmail($user->name, $token));
            return response()->json([
                'message' => 'Please check your Inbox / Spam / Promotions / Social tabs and click the activation link. If you can\'t find the email, try searching "Gows" on your mailbox',
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
