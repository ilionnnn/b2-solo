<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    public function index()
    {
        $pages = Auth::check() && Auth::user()->role === 1
            ? Information::with('user')->orderBy('date_modification', 'desc')->get()
            : Information::with('user')->where('statut', 'publié')->orderBy('date_modification', 'desc')->get();

        return view('information.index', compact('pages'));
    }

    public function show($id)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Connectez-vous pour lire les informations.');
        }

        $page = Information::with('user')->findOrFail($id);

        if ($page->statut !== 'publié' && Auth::user()->role !== 1) {
            abort(403);
        }

        return view('information.show', compact('page'));
    }

    public function create()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        return view('information.create');
    }

    public function edit($id)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $page = Information::findOrFail($id);

        if (Auth::user()->role !== 1 && $page->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres pages.');
        }

        return view('information.edit', compact('page'));
    }

    public function destroy($id)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $page = Information::findOrFail($id);

        if (Auth::user()->role !== 1 && $page->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez supprimer que vos propres pages.');
        }

        $page->delete();

        return redirect()->route('information.index')
            ->with('success', 'Page supprimée.');
    }
}
