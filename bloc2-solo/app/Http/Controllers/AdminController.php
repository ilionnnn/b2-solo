<?php

namespace App\Http\Controllers;

use App\Models\ExerciceRespiration;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'users' => User::all(),
            'exercices' => ExerciceRespiration::with('user')->get(),
            'total_users' => User::count(),
            'total_exercices' => ExerciceRespiration::count(),
            'total_admins' => User::where('role', 1)->count(),
        ]);
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }

    public function destroyExercice($id)
    {
        ExerciceRespiration::findOrFail($id)->delete();

        return back()->with('success', 'Exercice supprimé.');
    }
}
