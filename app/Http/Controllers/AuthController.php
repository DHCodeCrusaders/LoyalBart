<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function show()
    {
        return Inertia::render('Auth/Login');
    }

    public function store()
    {
        Auth::login(User::first());

        return to_route('home');
    }

    public function destroy()
    {
        Auth::logout();

        return to_route('login');
    }
}
