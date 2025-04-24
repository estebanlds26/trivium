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
    switch (Auth::user()->rol_id) {
        case 1:
            return view('dashboard.admin')->with('section', 'contact');
        case 2:
            return view('dashboard.client')->with('section', 'contact');
        case 3:
            return view('dashboard.producer')->with('section', 'contact');
    }
})->middleware(['auth'])->name('contact');

Route::get('/tienda', function () {
    switch (Auth::user()->rol_id) {
        case 1:
            return view('dashboard.admin')->with('section', 'store');
        case 2:
            return view('dashboard.client')->with('section', 'store');
        case 3:
            return view('dashboard.producer')->with('section', 'store');
    }
})->middleware(['auth'])->name('store');
Route::get('/ajustes', function () {
    switch (Auth::user()->rol_id) {
        case 1:
            return view('dashboard.admin')->with('section', 'settings');
        case 2:
            return view('dashboard.client')->with('section', 'settings');
        case 3:
            return view('dashboard.producer')->with('section', 'settings');
    }
})->middleware(['auth'])->name('settings');
Route::get('/ayuda', function () {
    switch (Auth::user()->rol_id) {
        case 1:
            return view('dashboard.admin')->with('section', 'help');
        case 2:
            return view('dashboard.client')->with('section', 'help');
        case 3:
            return view('dashboard.producer')->with('section', 'help');
    }
})->middleware(['auth'])->name('help');

Route::get('/', function () {
    if (Auth::check()) {
        switch (Auth::user()->rol_id) {
            case 1:
                return view('dashboard.admin');
            case 2:
                return view('dashboard.client');
            case 3:
                return view('dashboard.producer');
        }
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
