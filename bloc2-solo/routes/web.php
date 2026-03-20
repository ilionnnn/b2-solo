<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ExerciceRespirationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;


//Page d'accueil

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth'])->name('dashboard');


Route::get('/profile/edit', [ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('profile.edit');


Route::middleware(['auth'])->group(function () {


    //Profil

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');


    //Exercices


    Route::get('/exercice-respiration', [ExerciceRespirationController::class, 'index'])->name('exercice_respiration.index');

    Route::get('/exercice-respiration/create', [ExerciceRespirationController::class, 'create'])->name('exercice_respiration.create')->middleware('auth');

    Route::post('/exercice-respiration', [ExerciceRespirationController::class, 'store'])->name('exercice_respiration.store')->middleware('auth');

    Route::get('/exercice-respiration/{id}', [ExerciceRespirationController::class, 'show'])->name('exercice_respiration.show');

    Route::get('/exercice-respiration/{id}/edit', [ExerciceRespirationController::class, 'edit'])->name('exercice_respiration.edit')->middleware('auth');

    Route::put('/exercice-respiration/{id}', [ExerciceRespirationController::class, 'update'])->name('exercice_respiration.update')->middleware('auth');

    Route::delete('/exercice-respiration/{id}', [ExerciceRespirationController::class, 'destroy'])->name('exercice_respiration.destroy')->middleware('auth');

    //Informations

    Route::get('/information', [InformationController::class, 'index'])->name('information.index');

    Route::get('/information/create', [InformationController::class, 'create'])->name('information.create')->middleware('auth');

    Route::post('/information', [InformationController::class, 'store'])->name('information.store')->middleware('auth');

    Route::get('/information/{id}', [InformationController::class, 'show'])->name('information.show');

    Route::get('/information/{id}/edit', [InformationController::class, 'edit'])->name('information.edit')->middleware('auth');

    Route::put('/information/{id}', [InformationController::class, 'update'])->name('information.update')->middleware('auth');

    Route::delete('/information/{id}', [InformationController::class, 'destroy'])->name('information.destroy')->middleware('auth');

    //Favoris

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    Route::post('/favorites/add', [FavoriteController::class, 'store'])->name('favorites.store');

    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

});



//Admin

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users');

});


//Breeze

require __DIR__.'/auth.php';
