<?php

namespace App\Listeners;

use App\Events\StravaEvent;
use App\Http\Controllers\StravaTrait;
use App\Models\Activity;
// use App\Models\Log;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SaveActivity implements ShouldQueue
{
    use StravaTrait;

    public $tries = 3;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\StravaEvent  $event
     * @return void
     */
    public function handle(StravaEvent $event)
    {
        $eventData = $event->eventData;
        $objectType = $eventData['object_type']; //activity or athlete
        $aspectType = $eventData['aspect_type']; //create, update, or delete
        $objectId = $eventData['object_id']; //activity id or athletes id
        $athleteId = $eventData['owner_id'];

        if ($objectType == 'activity' && ($aspectType == 'create' || $aspectType == 'update')) {
            $user = User::where('strava_athlete_id', $athleteId)->first();
            if ($user == null) {
                return;
            }
            $stravaToken = $user->strava_token;
            $stravaRefreshToken = $user->strava_refresh_token;
            $stravaTokenExpiresAt = $user->strava_expires_at;
            $activityId = $objectId;
            if ($athleteId == null || $stravaToken == null) {
                Log::info('event-save-activity', ['msg' => 'Strava token undefined']);
                return;
            }

            if (time() > $stravaTokenExpiresAt) {
                //request new token
                $requestNewToken = $this->refreshTokenRequest($stravaRefreshToken);
                $httpCode = $requestNewToken['httpCode'];
                $data = $requestNewToken['data'];

                if ($httpCode == null) {
                    Log::info('event-save-activity', ['msg' => 'Strava token expired. Request new token failed!']);
                    return;
                }

                if ($httpCode != 200) {
                    Log::info('event-save-activity', ['msg' => 'Strava token expired. ' . $data->message]);
                    return;
                }

                $stravaToken = $data->access_token;
                $user = User::find($user->id);
                try {
                    $user->strava_token = $data->access_token;
                    $user->strava_refresh_token = $data->refresh_token;
                    $user->strava_expires_at = $data->expires_at;
                    $user->save();
                } catch (\Exception $e) {
                    Log::info('event-save-activity', ['msg' => 'Strava token expired. Failed save new token!']);
                    return;
                }
            }

            //request activity
            $getActivity = $this->getNewActivity($stravaToken, $activityId);
            if ($getActivity['status'] == false) {
                Log::info('event-save-activity', ['msg' => 'Failed get activity. ' . $getActivity['data']['message']]);
                return;
            }

            if ($getActivity['httpCode'] != 200) {
                $data = json_decode($getActivity['data']);
                Log::info('event-save-activity', ['msg' => 'Failed get activity. ' . $data->message]);
                return;
            }

            $activity = Activity::where('strava_id', '=', $activityId)->first();
            if ($activity == null) {
                $activity = new Activity();
                $activity->user_id = $user->id;
                $activity->strava_id = $activityId;
                $activity->strava_data = $getActivity['data'];
            } else {
                $activity->strava_data = $getActivity['data'];
            }

            try {
                $activity->save();
                return;
            } catch (\Exception $e) {
                Log::info('event-save-activity', ['msg' => 'Failed get activity. ' . $e->getMe]);
            }
        }

        //TODO, logic for delete event
        return;
    }
}
