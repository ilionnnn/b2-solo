@extends('layouts.app')

@section('content')

    <h1 class="text-3xl mb-6">Ajouter une émotion</h1>

    <form method="POST" action="/emotions" class="space-y-4">
        @csrf

        <select name="emotion_id" class="w-full p-2 text-black rounded">
            @foreach($emotions as $emotion)
                <option value="{{ $emotion->id }}">
                    {{ $emotion->name }}
                </option>
            @endforeach
        </select>

        <input type="number" name="intensity" placeholder="Intensité (1-10)"
               class="w-full p-2 text-black rounded">

        <textarea name="note" placeholder="Note..."
                  class="w-full p-2 text-black rounded"></textarea>

        <button class="bg-emerald-600 px-4 py-2 rounded">
            Enregistrer
        </button>

    </form>

@endsection
