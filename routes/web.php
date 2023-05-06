<?php

use App\Http\Controllers\AcceptBarterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Organizer;
use App\Http\Controllers\HuntController;
use App\Http\Controllers\InitiateBarterController;
use App\Http\Controllers\ListBarterController;
use App\Http\Controllers\LoyaltyProgramController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/loyalty-programs')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'loyalty-programs', 'as' => 'loyalty-programs.'], function () {
        Route::get('/', [LoyaltyProgramController::class, 'index'])->name('index');
        Route::get('{program}', [LoyaltyProgramController::class, 'show'])->name('show');
    });

    Route::group(['prefix' => 'baters', 'as' => 'barters.'], function () {
        Route::get('/', ListBarterController::class)->name('index');
        Route::post('initiate', InitiateBarterController::class)->name('initiate');
        Route::post('{barter}/accept', AcceptBarterController::class)->name('accept');
    });

    Route::get('hunts', [HuntController::class, 'index'])->name('hunts.index');
    Route::get('hunts/{id}', [HuntController::class, 'show'])->name('hunts.show');

    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    Route::get('profile/{uuid?}', [ProfileController::class, 'show'])->name('profile.show');
});

Route::group(['middleware' => 'auth', 'prefix' => 'organizer', 'as' => 'organizer.'], function () {
    Route::get('hunts', [Organizer\HuntController::class, 'index'])->name('hunts.index');
    Route::get('hunts/{id}', [Organizer\HuntController::class, 'show'])->name('hunts.show');
});

Route::get('login', [AuthController::class, 'show'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthController::class, 'store'])->middleware('guest');
