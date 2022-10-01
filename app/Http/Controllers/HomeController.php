<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $data = [
            'name' => $user->name,
            'email' => $user->email
        ];

        return response()->json([
            'data' => $data,
            'message' => 'User Profile',
        ], 200);
    }

    public function verifyEmail(Request $request, $token)
    {
        $email = explode('#', base64_decode($token))[0];
        $user = User::where([
            ['verification_token', '=', $token]
        ])->first();

        if (!empty($user)) {
            if ($user->email_verified_at != null) {
                return view('email-verification/form', ['email' => $email]);
            }
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->status = 'active';
            $user->save();

            return view('email-verification/form', ['email' => $email]);
        }
        return view('email-verification/form-wrong', ['email' => $email]);
    }

    public function passwordReset(Request $request, $token)
    {
        try {
            $email = explode('#', base64_decode($token))[0];

            $user = User::where('email', '=', $email)->first();
            if (strtotime($user->forgot_token_expired) < time()) {
                return view('forgot-password/expire');
            } else {
                return view('forgot-password/form', ['email' => $email]);
            }
        } catch (\Exception $e) {
            return view('forgot-password/error', ['error_code' => '#001']);
        }
    }

    public function passwordResetSubmit(Request $request)
    {
        try {
            $user = User::where('email', '=', $request->email)->first();
            if ($user == null) {
                return view('forgot-password/error', ['error_code' => '#002']);
            }
            $user->password = Hash::make($request->input('password'));
            $user->forgot_token_expired = '2000-01-01 01:01:01';
            $user->save();

            return view('forgot-password/success');
        } catch (\Exception $e) {
            return view('forgot-password/error', ['error_code' => '#002']);
        }
    }
}
