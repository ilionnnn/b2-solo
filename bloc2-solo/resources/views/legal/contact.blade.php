@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="max-w-3xl mx-auto py-10 space-y-6">
    <h1 class="font-lora text-3xl font-semibold text-white">Contact</h1>
    <p>Une question, une remarque ou une demande relative à vos données personnelles ?</p>
    <ul class="space-y-2 text-slate-300">
        <li>Support utilisateur : <a href="{{ route('support') }}" class="text-emerald-400 underline">page support</a></li>
        <li>Protection des données (DPO) : <span class="text-emerald-400">dpo@cesizen.example</span></li>
        <li>Signalement de sécurité : <span class="text-emerald-400">security@cesizen.example</span></li>
    </ul>
</div>
@endsection
