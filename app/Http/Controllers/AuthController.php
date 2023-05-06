<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function show()
    {
        return Inertia::render('Auth/Login');
    }

    public function store()
    {
        $user = User::where('email', request('email'))->first();

        if (!$user || !Hash::check(request('password'), $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ]);
        }

        Auth::login($user);

        return to_route($user->is_organizer ? 'organizer.home' : 'home');
    }

    public function destroy()
    {
        Auth::logout();

        return to_route('login');
    }
}
