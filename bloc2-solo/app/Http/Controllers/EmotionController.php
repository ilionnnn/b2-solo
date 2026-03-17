<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmotionLog;
use App\Models\Emotion;

class EmotionController extends Controller
{

    public function index()
    {
        $logs = EmotionLog::where('user_id', auth()->id())
            ->with('emotion')
            ->latest()
            ->get();

        return view('emotions.index', compact('logs'));
    }


    public function create()
    {
        $emotions = Emotion::all();

        return view('emotions.create', compact('emotions'));
    }


    public function store(Request $request)
    {
        EmotionLog::create([
            'user_id' => auth()->id(),
            'emotion_id' => $request->emotion_id,
            'intensity' => $request->intensity,
            'note' => $request->note,
            'logged_at' => now()
        ]);

        return redirect()->route('emotions.index');
    }


    public function edit($id)
    {
        $log = EmotionLog::findOrFail($id);
        $emotions = Emotion::all();

        return view('emotions.edit', compact('log','emotions'));
    }


    public function update(Request $request, $id)
    {
        $log = EmotionLog::findOrFail($id);

        $log->update([
            'emotion_id' => $request->emotion_id,
            'intensity' => $request->intensity,
            'note' => $request->note
        ]);

        return redirect()->route('emotions.index');
    }


    public function destroy($id)
    {
        $log = EmotionLog::findOrFail($id);

        $log->delete();

        return redirect()->route('emotions.index');
    }

}
