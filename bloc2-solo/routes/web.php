<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\EmotionController;
use App\Http\Controllers\BreathingExerciseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;


/*
|--------------------------------------------------------------------------
| PAGE ACCUEIL
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth'])->name('dashboard');


Route::get('/profile/edit', [ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('profile.edit');
/*
|--------------------------------------------------------------------------
| ROUTES CONNECTÉES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    -----------------
    PROFIL
    -----------------
    */

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');



    /*
    -----------------
    EXERCICES
    -----------------
    */

    Route::get('/exercises', [BreathingExerciseController::class, 'index'])->name('exercises.index');

    Route::get('/exercises/{id}', [BreathingExerciseController::class, 'show'])->name('exercises.show');



    /*
    -----------------
    TRACKER EMOTIONS
    -----------------
    */

    Route::get('/emotions', [EmotionController::class, 'index'])->name('emotions.index');

    Route::get('/emotions/create', [EmotionController::class, 'create'])->name('emotions.create');

    Route::post('/emotions', [EmotionController::class, 'store'])->name('emotions.store');

    Route::get('/emotions/{id}/edit', [EmotionController::class, 'edit'])->name('emotions.edit');

    Route::put('/emotions/{id}', [EmotionController::class, 'update'])->name('emotions.update');

    Route::delete('/emotions/{id}', [EmotionController::class, 'destroy'])->name('emotions.destroy');



    /*
    -----------------
    FAVORIS
    -----------------
    */

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    Route::post('/favorites/add', [FavoriteController::class, 'store'])->name('favorites.store');

    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

});



/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users');

});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (BREEZE)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
