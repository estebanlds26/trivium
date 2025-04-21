<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Allow authenticated users to provide a role ID, but validate it
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
                'name' => ['required', 'string', 'max:255'],
                'cellphone' => ['required', 'string', 'max:255', 'unique:'.User::class],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'email_confirmation' => ['required', 'same:email'], // Ensure email confirmation matches
                'password' => ['required', 'confirmed', Rules\Password::defaults()], // Ensure password confirmation matches
                'rol_id' => ['required', 'exists:roles,id'], // Validate that the role exists
            ]);

            $rolId = $request->rol_id; // Use the provided role ID
        } else {
            // For unauthenticated users, force rol_id to 2
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
                'name' => ['required', 'string', 'max:255'],
                'cellphone' => ['required', 'string', 'max:255', 'unique:'.User::class],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'email_confirmation' => ['required', 'same:email'], // Ensure email confirmation matches
                'password' => ['required', 'confirmed', Rules\Password::defaults()], // Ensure password confirmation matches
            ]);

            $rolId = 2; // Force role ID to 2 for unauthenticated users
        }

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'cellphone' => $request->cellphone,
            'cellphone_verified_at' => null, // Default to null
            'profile_picture' => null, // Default to null
            'email' => $request->email,
            'email_verified_at' => null, // Default to null
            'password' => Hash::make($request->password),
            'rol_id' => $rolId, // Assign the role ID
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
