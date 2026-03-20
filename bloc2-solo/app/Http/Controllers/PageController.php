<?php

namespace App\Http\Controllers;

use App\Models\ExerciceRespiration;
use App\Models\Information;

class PageController extends Controller
{
    public function home()
    {
        $exercises = ExerciceRespiration::where('public', true)
            ->orderBy('date_creation', 'desc')
            ->take(3)
            ->get();

        $informations = Information::where('statut', 'publié')
            ->orderBy('date_modification', 'desc')
            ->take(3)
            ->get();

        return view('pages.home', compact('exercises', 'informations'));
    }
}
