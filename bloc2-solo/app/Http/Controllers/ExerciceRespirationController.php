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
        $exercice = ExerciceRespiration::with('user')->findOrFail($id);

        if (!$exercice->public && (!Auth::check() || Auth::user()->role !== 1)) {
            abort(403);
        }

        return view('exercice-respiration.show', compact('exercice'));
    }

    public function create()
    {
        return view('exercice-respiration.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'               => 'required|max:255',
            'description'       => 'nullable',
            'duree_inspiration' => 'required|integer|min:1',
            'duree_apnee'       => 'required|integer|min:0',
            'duree_expiration'  => 'required|integer|min:1',
            'nombre_cycles'     => 'required|integer|min:1',
            'public'            => 'boolean',
        ]);

        $inspiration = $request->duree_inspiration;
        $apnee       = $request->duree_apnee;
        $expiration  = $request->duree_expiration;
        $cycles      = $request->nombre_cycles;
        $type        = $apnee > 0 ? "{$inspiration}-{$apnee}-{$expiration}" : "{$inspiration}-{$expiration}";
        $totale      = ($inspiration + $apnee + $expiration) * $cycles;

        ExerciceRespiration::create([
            'nom'               => $request->nom,
            'description'       => $request->description,
            'duree_inspiration' => $inspiration,
            'duree_apnee'       => $apnee,
            'duree_expiration'  => $expiration,
            'duree_totale'      => $totale,
            'nombre_cycles'     => $cycles,
            'type'              => $type,
            'public'            => $request->has('public'),
            'user_id'           => Auth::id(),
            'date_creation'     => now(),
        ]);

        return redirect()->route('exercice_respiration.index')
            ->with('success', 'Exercice créé avec succès.');
    }

    public function edit($id)
    {
        $exercice = ExerciceRespiration::findOrFail($id);
        return view('exercice-respiration.edit', compact('exercice'));
    }

    public function update(Request $request, $id)
    {
        $exercice = ExerciceRespiration::findOrFail($id);

        $request->validate([
            'nom'               => 'required|max:255',
            'description'       => 'nullable',
            'duree_inspiration' => 'required|integer|min:1',
            'duree_apnee'       => 'required|integer|min:0',
            'duree_expiration'  => 'required|integer|min:1',
            'nombre_cycles'     => 'required|integer|min:1',
            'public'            => 'boolean',
        ]);

        $inspiration = $request->duree_inspiration;
        $apnee       = $request->duree_apnee;
        $expiration  = $request->duree_expiration;
        $cycles      = $request->nombre_cycles;
        $type        = $apnee > 0 ? "{$inspiration}-{$apnee}-{$expiration}" : "{$inspiration}-{$expiration}";
        $totale      = ($inspiration + $apnee + $expiration) * $cycles;

        $exercice->update([
            'nom'               => $request->nom,
            'description'       => $request->description,
            'duree_inspiration' => $inspiration,
            'duree_apnee'       => $apnee,
            'duree_expiration'  => $expiration,
            'duree_totale'      => $totale,
            'nombre_cycles'     => $cycles,
            'type'              => $type,
            'public'            => $request->has('public'),
        ]);

        return redirect()->route('exercice_respiration.index')
            ->with('success', 'Exercice modifié avec succès.');
    }

    public function destroy($id)
    {
        ExerciceRespiration::findOrFail($id)->delete();
        return redirect()->route('exercice_respiration.index')
            ->with('success', 'Exercice supprimé.');
    }
}
