<?php

namespace App\Http\Controllers;

use App\Models\ExerciceRespiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciceRespirationController extends Controller
{

    public function index()
    {
        $exercices = Auth::check() && Auth::user()->role === 1
            ? ExerciceRespiration::with('user')->orderBy('date_creation', 'desc')->get()
            : ExerciceRespiration::with('user')->where('public', true)->orderBy('date_creation', 'desc')->get();

        return view('exercice-respiration.index', compact('exercices'));
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Connectez-vous pour accéder aux exercices.');
        }

        $exercice = ExerciceRespiration::with('user')->findOrFail($id);

        if (!$exercice->public && Auth::user()->role !== 1) {
            abort(403);
        }

        return view('exercice-respiration.show', compact('exercice'));
    }

    public function create()
    {
        if (!Auth::check()) return redirect()->route('login');
        return view('exercice-respiration.create');
    }

    public function edit($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        $exercice = ExerciceRespiration::findOrFail($id);

        if (Auth::user()->role !== 1 && $exercice->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres exercices.');
        }

        return view('exercice-respiration.edit', compact('exercice'));
    }

    public function destroy($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        $exercice = ExerciceRespiration::findOrFail($id);

        if (Auth::user()->role !== 1 && $exercice->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez supprimer que vos propres exercices.');
        }

        $exercice->delete();
        return redirect()->route('exercice_respiration.index')
            ->with('success', 'Exercice supprimé.');
    }
}
