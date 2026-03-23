<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RessourcesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeRessourceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ExerciceRespirationController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

///////////////////////////////////////////////////////////
// ACCUEIL
///////////////////////////////////////////////////////////

Route::get('/', [PageController::class, 'home'])->name('home');

///////////////////////////////////////////////////////////
// EXERCICES DE RESPIRATION
///////////////////////////////////////////////////////////

Route::get('/exercice-respiration', [ExerciceRespirationController::class, 'index'])->name('exercice_respiration.index');
Route::get('/exercice-respiration/create', [ExerciceRespirationController::class, 'create'])->name('exercice_respiration.create')->middleware('auth');
Route::post('/exercice-respiration', [ExerciceRespirationController::class, 'store'])->name('exercice_respiration.store')->middleware('auth');
Route::get('/exercice-respiration/{id}', [ExerciceRespirationController::class, 'show'])->name('exercice_respiration.show');
Route::get('/exercice-respiration/{id}/edit', [ExerciceRespirationController::class, 'edit'])->name('exercice_respiration.edit')->middleware('auth');
Route::put('/exercice-respiration/{id}', [ExerciceRespirationController::class, 'update'])->name('exercice_respiration.update')->middleware('auth');
Route::delete('/exercice-respiration/{id}', [ExerciceRespirationController::class, 'destroy'])->name('exercice_respiration.destroy')->middleware('auth');

///////////////////////////////////////////////////////////
// INFORMATIONS
///////////////////////////////////////////////////////////

Route::get('/information', [InformationController::class, 'index'])->name('information.index');
Route::get('/information/create', [InformationController::class, 'create'])->name('information.create')->middleware('auth');
Route::post('/information', [InformationController::class, 'store'])->name('information.store')->middleware('auth');
Route::get('/information/{id}', [InformationController::class, 'show'])->name('information.show');
Route::get('/information/{id}/edit', [InformationController::class, 'edit'])->name('information.edit')->middleware('auth');
Route::put('/information/{id}', [InformationController::class, 'update'])->name('information.update')->middleware('auth');
Route::delete('/information/{id}', [InformationController::class, 'destroy'])->name('information.destroy')->middleware('auth');

///////////////////////////////////////////////////////////
// RESSOURCES
///////////////////////////////////////////////////////////

Route::resource('ressources', RessourcesController::class);

///////////////////////////////////////////////////////////
// CATEGORIES
///////////////////////////////////////////////////////////

Route::resource('category', CategoryController::class);

///////////////////////////////////////////////////////////
// TYPES DE RESSOURCE
///////////////////////////////////////////////////////////

Route::resource('type_ressource', TypeRessourceController::class);

///////////////////////////////////////////////////////////
// PROFIL
///////////////////////////////////////////////////////////

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

///////////////////////////////////////////////////////////
// ADMIN
///////////////////////////////////////////////////////////

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/',                         [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/users/{id}',            [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::delete('/exercices/{id}',        [AdminController::class, 'destroyExercice'])->name('admin.exercices.destroy');
});

///////////////////////////////////////////////////////////
// MODERATEUR
///////////////////////////////////////////////////////////

Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::view('/moderation', 'moderator.dashboard')->name('moderator.dashboard');
});

///////////////////////////////////////////////////////////
// PAGES LEGALES
///////////////////////////////////////////////////////////

Route::get('/mentions-legales', fn() => view('legal.mentions'))->name('mentions-legales');
Route::get('/cgu', fn() => view('legal.cgu'))->name('cgu');
Route::get('/contact', fn() => view('legal.contact'))->name('contact');
Route::get('/support', fn() => view('support'))->name('support');

///////////////////////////////////////////////////////////
// AUTH (login, register, etc.)
///////////////////////////////////////////////////////////

require __DIR__.'/auth.php';
