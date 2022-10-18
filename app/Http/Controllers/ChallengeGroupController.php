<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeUser;
use App\Models\ChallengeGroup;
use App\Models\GroupUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ChallengeGroupController extends Controller
{
    public function save(Request $request)
    {
        $input = $request->all();
        $user = $request->user();

        $validator = Validator::make(
            $input,
            [
                'challenge_id' => 'required',
                'name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }

        $challenge = Challenge::find($input['challenge_id']);
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
            $challengeGroup = new ChallengeGroup();
            $challengeGroup->challenge_id = $input['challenge_id'];
            $challengeGroup->name = $input['name'];
            $challengeGroup->save();
            return response()->json([
                'message' => 'Success add group !'
            ], 200);
        } catch (Exception $e) {
            Log::info('save-group', ['msg' => $e->getMessage()]);
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $input = $request->input();

        $challengeGroup = ChallengeGroup::find($id);
        if ($challengeGroup == null) {
            return response()->json([
                'message' => 'Challenge group not found !',
                'data' => null,
            ], 400);
        }

        if ($challengeGroup->challenge->user_id != $user->id) {
            return response()->json([
                'message' => 'You don\'t have permission to edit this challenge group !',
                'data' => null,
            ], 403);
        }

        try {
            $challengeGroup->name = $input['name'];
            $challengeGroup->save();
            return response()->json([
                'message' => 'Success edit group !'
            ], 200);
        } catch (Exception $e) {
            Log::info('edit-group', ['msg' => $e->getMessage()]);
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        $challengeGroup = ChallengeGroup::find($id);
        if ($challengeGroup == null) {
            return response()->json([
                'message' => 'Challenge group not found !',
                'data' => null,
            ], 400);
        }

        if ($challengeGroup->challenge->user_id != $user->id) {
            return response()->json([
                'message' => 'You don\'t have permission to delete this challenge group !',
                'data' => null,
            ], 403);
        }

        DB::beginTransaction();
        try {
            $groupUsers = $challengeGroup->groupuser;
            foreach ($groupUsers as $groupUser) {
                $groupUser->delete();
            }
            $challengeGroup->delete();
            DB::commit();

            return response()->json([
                'message' => 'Challenge group deleted !'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('delete-challenge', ['msg' => $e->getMessage()]);
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function detail(Request $request, $id)
    {
        $challengeGroup = ChallengeGroup::find($id);
        if ($challengeGroup == null) {
            return response()->json([
                'message' => 'Challenge group not found !',
                'data' => null,
            ], 400);
        }
        $challengeGroup->groupuser;
        return response()->json([
            'data' => $challengeGroup,
            'message' => 'Challenge Group Detail'
        ], 200);
    }

    public function list($challengeId)
    {
        $challengeGroup = ChallengeGroup::where('challenge_id', '=', $challengeId)->get();
        return response()->json([
            'data' => $challengeGroup,
            'message' => 'Challenge Group List'
        ], 200);
    }
}
