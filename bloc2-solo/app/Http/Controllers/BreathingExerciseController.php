<?php

namespace App\Http\Controllers;

use App\Models\BreathingExercise;

class BreathingExerciseController extends Controller
{

    public function index()
    {
        $exercises = BreathingExercise::all();

        return view('exercises.index', compact('exercises'));
    }


    public function show($id)
    {
        $exercise = BreathingExercise::findOrFail($id);

        return view('exercises.show', compact('exercise'));
    }

}
