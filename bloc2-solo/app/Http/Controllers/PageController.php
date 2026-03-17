<?php

namespace App\Http\Controllers;

use App\Models\BreathingExercise;

class PageController extends Controller
{

    public function home()
    {
        $exercises = BreathingExercise::all();

        return view('pages.home', compact('exercises'));
    }

}
