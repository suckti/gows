<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StravaController extends Controller
{
    use StravaTrait;

    public function exchangeToken(Request $request)
    {
        $scope = explode(':', $request->get('scope'));
        $code = $request->get('code');

        if (empty($scope) || count($scope) < 2) {
            return view('strava/failed', ['message' => 'Undefine Scope']);
        }
        $parseScope = explode(',', $scope[1]);
        if (empty($parseScope)) {
            return view('strava/failed', ['message' => 'You must authorize the scope']);
        }

        if (empty($code)) {
            return view('strava/failed', ['message' => 'Undefined authorization code']);
        }

        $requestExchange = $this->exchangeTokenRequest($code);
        $httpCode = $requestExchange['httpCode'];
        $data = $requestExchange['data'];

        if ($httpCode == null) {
            return view('strava/failed', ['message' => 'Failed to get token.']);
        }
        if ($httpCode == 200) {
            try {
                $defaultPassword = bcrypt($data->athlete->id);
                $user = User::where('strava_athlete_id', $data->athlete->id)->first();
                if (empty($user)) {
                    $user = new User();
                    $user->password = $defaultPassword;
                }
                $user->name = $data->athlete->firstname . ' ' . $data->athlete->lastname;
                $user->username = $data->athlete->username;
                $user->avatar = $data->athlete->profile;
                $user->status = 'active';
                $user->strava_athlete_id = $data->athlete->id;
                $user->strava_token = $data->access_token;
                $user->strava_refresh_token = $data->refresh_token;
                $user->strava_expires_at = $data->expires_at;
                $user->save();

                Auth::login($user);
                
                // Hash check for password
                if (Hash::check($data->athlete->id, $user->password)) {
                    return redirect()->route('set-password');
                }

                return redirect()->route('dashboard');
            } catch (\Exception $e) {
                $failedMessage = 'Failed: Update User. Please revoke the app access on strava and try it again!'. $e->getMessage();
                return redirect()->route('login')->withErrors(['message' => $failedMessage]);
            }
        } else {
            $failedMessage = 'Failed: ' . $data->message . ' Please revoke the app access on strava and try it again!';
            return redirect()->route('login')->withErrors(['message' => $failedMessage]);
        }
    }
}
