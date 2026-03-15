<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\EmotionController;
use App\Http\Controllers\BreathingExerciseController;
use App\Http\Controllers\ProfileController;

Route::get('/', [PageController::class, 'home']);

Route::get('/pages/{slug}', [PageController::class, 'show']);

Route::middleware('auth')->group(function () {

    Route::resource('emotions', EmotionController::class);

    Route::resource('exercises', BreathingExerciseController::class);

    Route::get('/profile', [ProfileController::class, 'index']);

});
?>
