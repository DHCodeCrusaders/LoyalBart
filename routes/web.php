<?php

use App\Models\LoyaltyProgram;
use App\Models\Participant;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $userPrograms = Participant::query()
        ->where('participant_id', Auth::id())
        ->pluck('loyalty_program_id')
        ->toArray();

    return Inertia::render('LoyaltyProgram/Index', [
        'programs' => LoyaltyProgram::query()
            ->orderBy('title')
            ->get()
            ->map(function ($item) use ($userPrograms) {
                $item->is_participated = in_array($item->id, $userPrograms);
                return $item;
            })
    ]);
})->name('home');

Route::get('login', function () {
    return Inertia::render('Auth/Login', []);
})->name('login')->middleware('guest');

Route::post('login', function () {
    Auth::login(User::first());

    return to_route('home');
})->middleware('guest');
