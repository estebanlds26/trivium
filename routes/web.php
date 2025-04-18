<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//make this route for unauthenticated users
//make this route to welcome for unauthenticated users

Route::get('/acerca-de', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome')->with('section', 'about');
});
Route::get('/productos', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome')->with('section', 'products');
});
Route::get('/iniciar-sesion', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome')->with('section', 'login');
});
Route::get('/registrarse', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome')->with('section', 'register');
});

Route::get('/contacto', function () {
    return view('dashboard.client')->with('section', 'contact');
})->middleware(['auth'])->name('contact');
Route::get('/tienda', function () {
    return view('dashboard.client')->with('section', 'store');
})->middleware(['auth'])->name('store');
Route::get('/ajustes', function () {
    return view('dashboard.client')->with('section', 'settings');
})->middleware(['auth'])->name('settings');
Route::get('/ayuda', function () {
    return view('dashboard.client')->with('section', 'help');
})->middleware(['auth'])->name('help');

Route::get('/', function () {
    if (Auth::check()) {
        return view('dashboard.client');
    } else {
        return view('welcome', ['section' => 'home']);
    }
})->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
