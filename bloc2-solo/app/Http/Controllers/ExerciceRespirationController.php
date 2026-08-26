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
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Connectez-vous pour accéder aux exercices.');
        }

        $exercice = ExerciceRespiration::with('user')->findOrFail($id);

        if (! $exercice->public && Auth::user()->role !== 1) {
            abort(403);
        }

        return view('exercice-respiration.show', compact('exercice'));
    }

    public function create()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        return view('exercice-respiration.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nombre_cycles' => 'required|integer|min:1',
            'duree_inspiration' => 'required|integer|min:1',
            'duree_apnee' => 'nullable|integer|min:0',
            'duree_expiration' => 'required|integer|min:1',
            'public' => 'boolean',
        ]);

        $validated['public'] = $request->has('public');
        $validated['duree_totale'] = (
            $validated['duree_inspiration'] +
            ($validated['duree_apnee'] ?? 0) +
            $validated['duree_expiration']
        ) * $validated['nombre_cycles'];
        $validated['date_creation'] = now();
        $validated['user_id'] = Auth::id();
        $validated['type'] = 'manuel';

        ExerciceRespiration::create($validated);

        return redirect()->route('exercice_respiration.index')
            ->with('success', 'Exercice créé avec succès.');
    }

    public function edit($id)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $exercice = ExerciceRespiration::findOrFail($id);

        if (Auth::user()->role !== 1 && $exercice->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres exercices.');
        }

        return view('exercice-respiration.edit', compact('exercice'));
    }

    public function update(Request $request, $id)
    {
        $exercice = ExerciceRespiration::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nombre_cycles' => 'required|integer|min:1',
            'duree_inspiration' => 'required|integer|min:1',
            'duree_apnee' => 'nullable|integer|min:0',
            'duree_expiration' => 'required|integer|min:1',
            'public' => 'boolean',
        ]);

        $validated['public'] = $request->has('public');
        $validated['duree_totale'] = (
            $validated['duree_inspiration'] +
            ($validated['duree_apnee'] ?? 0) +
            $validated['duree_expiration']
        ) * $validated['nombre_cycles'];

        $exercice->update($validated);

        return redirect()->route('exercice_respiration.index')
            ->with('success', 'Exercice modifié avec succès.');
    }

    public function destroy($id)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $exercice = ExerciceRespiration::findOrFail($id);

        if (Auth::user()->role !== 1 && $exercice->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez supprimer que vos propres exercices.');
        }

        $exercice->delete();

        return redirect()->route('exercice_respiration.index')
            ->with('success', 'Exercice supprimé.');
    }
}
