<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BreathingExercise;
use App\Models\EmotionLog;
use App\Models\User;

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
