<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    public function list()
    {
        $activities = Activity::all();
        return view('activity.list', ['activities' => $activities]);
    }
}
