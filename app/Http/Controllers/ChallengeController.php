<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ChallengeController extends Controller
{
    public function save(Request $request)
    {
        $input = $request->all();
        $user = $request->user();

        $validator = Validator::make(
            $input,
            [
                'name' => 'required',
                'description' => 'required',
                'type' => 'required',
                'group_type' => 'required',
                'max_participant' => 'required',
                'start_date' => 'required',
                'end_date' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }
        $currentDate = date('Y-m-d');
        if ($input['start_date'] < $currentDate) {
            return response()->json([
                'message' => 'Date must be greater than today!',
                'data' => null,
            ], 400);
        }

        try {
            $challenge = new Challenge();
            $challenge->user_id = $user->id;
            $challenge->name = $input['name'];
            $challenge->description = $input['description'];
            $challenge->type = $input['type'];
            $challenge->group_type = $input['group_type'];
            $challenge->sport_type = $input['sport_type'];
            $challenge->max_participant = $input['max_participant'];
            $challenge->start_date = $input['start_date'];
            $challenge->end_date = $input['end_date'];
            $challenge->day_start_time = $input['day_start_time'];
            $challenge->day_end_time = $input['day_end_time'];
            $challenge->elevation_point = json_encode($input['elevation_point']);
            $challenge->distance_point = json_encode($input['distance_point']);
            $challenge->time_point = $input['time_point'];
            $challenge->status = 'upcoming';
            $challenge->deleted = false;
            $challenge->save();
            return response()->json([
                'message' => 'Success add challenge !'
            ], 200);
        } catch (Exception $e) {
            Log::info('save-challenge', ['msg' => $e->getMessage()]);
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $input = $request->input();

        $challenge = Challenge::find($id);
        if ($challenge == null) {
            return response()->json([
                'message' => 'Challenge not found !',
                'data' => null,
            ], 400);
        }

        if ($challenge->user_id != $user->id) {
            return response()->json([
                'message' => 'You don\'t have permission to access this challenge !',
                'data' => null,
            ], 403);
        }

        $currentDate = date('Y-m-d');
        if ($input['start_date'] < $currentDate || $challenge->status == 'ongoing') {
            return response()->json([
                'message' => 'Can\'t edit challenge that already running !',
                'data' => null,
            ], 400);
        }

        try {
            $challenge->name = $input['name'];
            $challenge->description = $input['description'];
            $challenge->type = $input['type'];
            $challenge->group_type = $input['group_type'];
            $challenge->sport_type = $input['sport_type'];
            $challenge->max_participant = $input['max_participant'];
            $challenge->start_date = $input['start_date'];
            $challenge->end_date = $input['end_date'];
            $challenge->day_start_time = $input['day_start_time'];
            $challenge->day_end_time = $input['day_end_time'];
            $challenge->elevation_point = $input['elevation_point'];
            $challenge->distance_point = $input['distance_point'];
            $challenge->time_point = $input['time_point'];
            $challenge->status = 'upcoming';
            $challenge->deleted = false;
            $challenge->save();
            return response()->json([
                'message' => 'Success edit challenge !'
            ], 200);
        } catch (Exception $e) {
            Log::info('edit-challenge', ['msg' => $e->getMessage()]);
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();

        $challenge = Challenge::find($id);
        if ($challenge == null) {
            return response()->json([
                'message' => 'Challenge not found !',
                'data' => null,
            ], 400);
        }

        if ($challenge->user_id != $user->id) {
            return response()->json([
                'message' => 'You don\'t have permission to access this challenge !',
                'data' => null,
            ], 403);
        }

        try {
            $challenge->deleted = true;
            $challenge->save();
            return response()->json([
                'message' => 'Challenge deleted !'
            ], 200);
        } catch (Exception $e) {
            Log::info('delete-challenge', ['msg' => $e->getMessage()]);
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function detail(Request $request, $id)
    {
        $challenge = Challenge::find($id);
        if ($challenge == null || $challenge->deleted == 1) {
            return response()->json([
                'message' => 'Challenge not found !',
                'data' => null,
            ], 400);
        }

        $challenge->elevation_point = json_decode($challenge->elevation_point);
        $challenge->distance_point = json_decode($challenge->distance_point);
        return response()->json([
            'data' => $challenge,
            'message' => 'Challenge Detail'
        ], 200);
    }

    public function list()
    {
        $challenges = Challenge::all();
        return view('challenge.list', ['challenges' => $challenges]);
    }

    public function athleteAdd(Request $request)
    {
        $input = $request->all();
        $user = $request->user();

        $validator = Validator::make(
            $input,
            [
                'challenge_id' => 'required',
            ]
        );

        $challengeId = $input['challenge_id'];
        $type = $input['type']; //'request' / 'add'
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }

        $challenge = Challenge::find($challengeId);
        $alreadyJoin = ChallengeUser::where('challenge_id', '=', $challengeId)
            ->where('user_id', '=', $user->id)
            ->first();

        if ($alreadyJoin !== null) {
            return response()->json([
                'message' => 'Athlete already join this challenge !'
            ], 200);
        }

        try {
            $challengeUser = new ChallengeUser();
            $challengeUser->challenge_id = $challengeId;
            $challengeUser->user_id = $user->id;
            $status = 'requested';
            if ($type == 'add' || $user->id == $challenge->user_id) {
                $status = 'approved';
            }
            $challengeUser->status = $status;
            $challengeUser->save();
            return response()->json([
                'message' => 'Request sent !'
            ], 200);
        } catch (Exception $e) {
            Log::info('save-challenge-user', ['msg' => $e->getMessage()]);
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function athleteDelete(Request $request)
    {
        $input = $request->all();
        $user = $request->user();

        $validator = Validator::make(
            $input,
            [
                'challenge_id' => 'required',
                'user_id' => 'required'
            ]
        );

        $challengeId = $input['challenge_id'];
        $userId = $input['user_id'];

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }

        $challenge = Challenge::find($challengeId);
        if ($user->id !== $challenge->user_id) {
            return response()->json([
                'message' => 'Delete failed. You are not admin this challenge!',
            ], 400);
        }

        try {
            $challengeUser = ChallengeUser::where('challenge_id', '=', $challengeId)
                ->where('user_id', '=', $userId)
                ->first();
            if ($challengeUser !== null) {
                $challengeUser->delete();
            }

            return response()->json([
                'message' => 'Athlete remove from this challenge!'
            ], 200);
        } catch (Exception $e) {
            Log::info('save-challenge-user', ['msg' => $e->getMessage()]);
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
