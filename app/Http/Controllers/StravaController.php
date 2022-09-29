<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class StravaController extends Controller
{
    public function exchangeToken(Request $request, $id)
    {
        $user = User::find($id);
        if (empty($user)) {
            return view('strava/failed', ['message' => 'User not found']);
        }

        $scope = explode(':', $request->get('scope'));
        $code = $request->get('code');

        if (empty($scope)) {
            return view('strava/failed', ['message' => 'Undefine Scope']);
        }
        $parseScope = explode(',', $scope[1]);
        if (empty($parseScope)) {
            return view('strava/failed', ['message' => 'You must authorize the scope']);
        }
        if (!in_array('read_all', $parseScope)) {
            return view('strava/failed', ['message' => 'You must authorize the scope']);
        }

        if (empty($code)) {
            return view('strava/failed', ['message' => 'Undefined authorization code']);
        }

        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://www.strava.com/oauth/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'client_id' => env('STRAVA_CLIENT_ID'),
                    'client_secret' => env('STRAVA_CLIENT_SECRET'),
                    'code' => $code,
                    'grant_type' => 'authorization_code'
                ]
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $data = json_decode($response);
            curl_close($curl);
            if ($httpCode == 200) {
                $user->strava_athlete_id = $data->athlete->id;
                $user->strava_token = $data->access_token;
                $user->strava_refresh_token = $data->refresh_token;
                $user->strava_expires_at = $data->expires_at;
                $user->save();
                return view('strava/success', ['message' => 'Success connect to Strava, you can go back to App.']);
            } else {
                $failedMessage = 'Failed: ' . $data->message . ' Please revoke the app access on strava and try it again!';
                return view('strava/failed', ['message' => $failedMessage]);
            }
            // invalid response
            // {"message":"Authorization Error","errors":[{"resource":"Application","field":"","code":"invalid"}]}
            // success response
            // {"token_type":"Bearer","expires_at":1664233221,"expires_in":21600,"refresh_token":"8d016910f17c460f9f3276a333d45f4c568cc5e7","access_token":"c2fea0967afa2feec760a73e443a9ec3be59658a","athlete":{"id":18067797,"username":"wsakti","resource_state":2,"firstname":"Wira","lastname":"Sakti","bio":"","city":"Bandung","state":"West Java","country":"Indonesia","sex":"M","premium":false,"summit":false,"created_at":"2016-10-16T11:15:04Z","updated_at":"2022-09-23T04:16:58Z","badge_type_id":0,"weight":58.0,"profile_medium":"https://dgalywyr863hv.cloudfront.net/pictures/athletes/18067797/6365879/6/medium.jpg","profile":"https://dgalywyr863hv.cloudfront.net/pictures/athletes/18067797/6365879/6/large.jpg","friend":null,"follower":null}}

            // save the response to database
        } catch (\Exception $e) {
            return view('strava/failed', ['message' => 'Failed to get token.']);
        }
    }

    public function saveActivity(Request $request)
    {
        $user = $request->user();
        $athleteId = $user->athlete_id;
        $stravaToken = $user->strava_token;
        $stravaRefreshToken = $user->strava_refresh_token;
        $stravaTokenExpiresAt = $user->strava_expires_at;

        if ($athleteId == null || $stravaRefreshToken == null) {
            return response()->json([
                'message' => 'Strava token undefined',
            ], 400);
        }

        if (time() > $stravaTokenExpiresAt) {
            //request new token
            $stravaToken = 'newtoken';
        }

        //request 
    }
}
