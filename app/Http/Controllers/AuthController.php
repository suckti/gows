<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use App\Mail\ForgotPassword;
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
                'email' => 'required|email',
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
            $existingUser = User::where('email', '=', $request->input('email'))->first();
            if ($existingUser !== null) {
                return response()->json([
                    'message' => 'Email already been used !',
                ], 400);
            }

            $token = base64_encode($request->input('email') . '#' . Str::random(12) . time());
            $user = new User();
            $user->email = $request->input('email');
            $user->name = $request->input('name');
            $user->password = Hash::make($request->input('password'));
            $user->verification_token = $token;
            $user->verification_token_expired = date('Y-m-d H:i:s', time() + (1 * 60 * 60));
            $user->status = 'pending';
            $user->save();

            Mail::to($request->input('email'))->send(new VerificationEmail($user->name, $token));

            $deviceName = ($request->device_name) ? $request->device_name : 'undefined-model';
            $token = $user->createToken($deviceName)->plainTextToken;
            return response()->json([
                'message' => 'Please check your Inbox / Spam / Promotions / Social tabs and click the activation link. If you can\'t find the email, try searching "Gows" on your mailbox',
                'data' => [
                    'access_token' => $token
                ]
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
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required'
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

        $deviceName = ($request->device_name) ? $request->device_name : 'undefined-model';
        $token = $user->createToken($deviceName)->plainTextToken;
        return response()->json([
            'message' => 'Successfully login',
            'data' => [
                'access_token' => $token
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logout',
            'data' => []
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }

        try {
            $token = base64_encode($request->input('email') . '#' . microtime());
            $user = User::where([
                ['email', '=', $request->input('email')],
            ])->first();
            if (empty($user)) {
                return response()->json([
                    'message' => 'User with email ' . $request->input('email') . ' not found.',
                ], 400);
            }

            Mail::to($request->input('email'))->send(new ForgotPassword($user->name, $token));
            $user->forgot_token = $token;
            $user->forgot_token_expired = date('Y-m-d H:i:s', time() + (1 * 60 * 60));
            $user->save();

            return response()->json([
                'message' => 'Please check your inbox at ' . $request->input('email') . ' to proceed.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
