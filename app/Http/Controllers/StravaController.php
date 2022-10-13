<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Log;
class StravaController extends Controller
{
    use StravaTrait;

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
                $user->strava_athlete_id = $data->athlete->id;
                $user->strava_token = $data->access_token;
                $user->strava_refresh_token = $data->refresh_token;
                $user->strava_expires_at = $data->expires_at;
                $user->save();
                return view('strava/success', ['message' => 'Success connect to Strava, you can go back to App.']);
            } catch (\Exception $e) {
                $failedMessage = 'Failed: Update User. Please revoke the app access on strava and try it again!';
                return view('strava/failed', ['message' => $failedMessage]);
            }
        } else {
            $failedMessage = 'Failed: ' . $data->message . ' Please revoke the app access on strava and try it again!';
            return view('strava/failed', ['message' => $failedMessage]);
        }
    }

    public function saveActivity(Request $request)
    {
        $user = $request->user();
        $athleteId = $user->strava_athlete_id;
        $stravaToken = $user->strava_token;
        $stravaRefreshToken = $user->strava_refresh_token;
        $stravaTokenExpiresAt = $user->strava_expires_at;
        $activityId = $request->input('activityId');
        if ($athleteId == null || $stravaToken == null) {
            return response()->json([
                'message' => 'Strava token undefined',
            ], 400);
        }

        if (time() > $stravaTokenExpiresAt) {
            //request new token
            $requestNewToken = $this->refreshTokenRequest($stravaRefreshToken);
            $httpCode = $requestNewToken['httpCode'];
            $data = $requestNewToken['data'];

            if ($httpCode == null) {
                return response()->json([
                    'message' => 'Strava token expired. Request new token failed!',
                ], 400);
            }

            if ($httpCode != 200) {
                return response()->json([
                    'message' => 'Strava token expired. ' . $data->message
                ], 400);
            }

            $stravaToken = $data->access_token;
            $user = User::find($user->id);
            try {
                $user->strava_token = $data->access_token;
                $user->strava_refresh_token = $data->refresh_token;
                $user->strava_expires_at = $data->expires_at;
                $user->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Strava token expired. Failed save new token!'
                ], 500);
            }
        }

        //request activity
        $getActivity = $this->getNewActivity($stravaToken, $activityId);
        if ($getActivity['status'] == false) {
            return response()->json([
                'message' => 'Failed get activity. ' . $getActivity['data']['message']
            ], 500);
        }

        if ($getActivity['httpCode'] != 200) {
            $data = json_decode($getActivity['data']);
            return response()->json([
                'message' => 'Failed get activity. ' . $data->message
            ], 500);
        }

        $activity = Activity::where('strava_id', '=', $activityId)->first();
        if ($activity != null) {
            return response()->json([
                'message' => 'Activity already exist !'
            ], 200);
        }

        try {
            $activity = new Activity();
            $activity->user_id = $user->id;
            $activity->strava_id = $activityId;
            $activity->strava_data = $getActivity['data'];
            $activity->save();
            return response()->json([
                'message' => 'Success add activity !'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed add activity ! ' . $e->getMessage()
            ], 500);
        }
    }

    public function webhookValidation(Request $request)
    {
        $hubChallenge = $request->input('hub_challenge');
        $hubVerifyToken = $request->input('hub_verify_token');

        $appToken = env('STRAVA_VERIFY_TOKEN');
        if ($hubVerifyToken != $appToken){
            return response()->json([
                'message' => 'App token not valid'
            ], 400);
        }

        return response()->json([
            'hub.challenge' => $hubChallenge
        ], 200);
    }

    public function webhookEvent(Request $request)
    {
        $data = [
            'type' => 'strava-event',
            'event' => $request->input('object_type'),
            'content' => json_encode($request->all()),
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ];
        Log::insert($data);

        $objectType = $request->input('object_type'); //activity or athlete
        $aspectType = $request->input('aspect_type'); //create, update, or delete
        $objectId = $request->input('object_id'); //activity id or athletes id

        if ($objectType == null) {
            return response()->json([
                'success' => false
            ], 400);    
        }

        return response()->json([
            'success' => true
        ], 200);

    }
}
