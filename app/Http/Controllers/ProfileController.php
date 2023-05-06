<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show($uuid = null)
    {
        return Inertia::render('Profile/Show', [
            'user' => $uuid ? User::where('uuid', $uuid)->first() : Auth::user(),
        ]);
    }
}
