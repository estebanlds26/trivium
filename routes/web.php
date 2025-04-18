<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome')->with('section', 'home');
});
Route::get('/acerca-de', function () {
    return view('welcome')->with('section', 'about');
});
Route::get('/productos', function () {
    return view('welcome')->with('section', 'products');
});
Route::get('/iniciar-sesion', function () {
    return view('welcome')->with('section', 'login');
});
Route::get('/registrarse', function () {
    return view('welcome')->with('section', 'register');
});



Route::get('/dashboard', function () {
    return view('dashboard.client');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
