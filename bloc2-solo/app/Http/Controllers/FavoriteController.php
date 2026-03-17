<?php

namespace App\Http\Controllers;

use App\Models\Favorite;

class FavoriteController extends Controller
{

    public function index()
    {
        $favorites = Favorite::where('user_id', auth()->id())
            ->with('exercise')
            ->get();

        return view('favorites.index', compact('favorites'));
    }


    public function store()
    {
        Favorite::create([
            'user_id' => auth()->id(),
            'exercise_id' => request('exercise_id')
        ]);

        return back();
    }


    public function destroy($id)
    {
        Favorite::destroy($id);

        return back();
    }

}
