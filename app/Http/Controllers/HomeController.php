<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class HomeController extends Controller
{
    public function verifyEmail(Request $request, $token)
    {
        $email = explode('#', base64_decode($token)[0]);
        $user = User::where([
            ['verification_token', '=', $token]
        ])->first();

        if (!empty($user)) {
            if ($user->email_verified_at != null) {
                return view('email-verification/form');
            }
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->status = 'active';
            $user->save();

            return view('email-verification/form');
        }
        return view('email-verification/form-wrong', ['email' => $email]);
    }
}
