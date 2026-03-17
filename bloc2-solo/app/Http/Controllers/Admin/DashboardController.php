<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\EmotionLog;
use App\Models\BreathingExercise;

class DashboardController extends Controller
{

    public function index()
    {

        $users = User::count();
        $emotions = EmotionLog::count();
        $sessions = BreathingExercise::count();

        return view('admin.dashboard', compact(
            'users',
            'emotions',
            'sessions'
        ));
    }

}
