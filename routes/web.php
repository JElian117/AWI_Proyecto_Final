<?php

use App\Http\Controllers\usuariosController;
use App\Http\Controllers\artistasController;
use App\Http\Controllers\albumesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search', function () {
    return view('search');
})->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Rutas para usuarios
    Route::get('/usuarios', [usuariosController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [usuariosController::class, 'create'])->name('usuarios.create');
    Route::get('/usuarios/editar/{id}', [usuariosController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/actualizar/{id}', [usuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/eliminar/{id}', [usuariosController::class, 'delete'])->name('usuarios.delete');

    //Rutas para artistas
    Route::get('/artistas', [artistasController::class, 'index'])->name('artistas.index');
    Route::post('/artistas', [artistasController::class, 'create'])->name('artistas.create');
    Route::get('/artistas/editar/{id}', [artistasController::class, 'edit'])->name('artistas.edit');
    Route::put('/artistas/actualizar/{id}', [artistasController:: class, 'update'])->name('artistas.update');
    Route::delete('/artistas/eliminar/{id}', [artistasController::class, 'delete'])->name('artistas.delete');

    //Rutas para álbumes
    Route::get('/albumes', [albumesController::class, 'index'])->name('albumes.index');
    Route::post('/albumes', [albumesController::class, 'create'])->name('albumes.create');
    Route::get('/albumes/editar/{id}', [albumesController::class, 'edit'])->name('albumes.edit');
    Route::put('/albumes/actualizar/{id}', [albumesController::class, 'update'])->name('albumes.update');
    Route::delete('/albumes/eliminar/{id}', [albumesController::class, 'delete'])->name('albumes.delete');
    Route::post('/albumes/reviews', [albumesController::class, 'storeReview'])->name('reviews.store');

});

require __DIR__.'/auth.php';
