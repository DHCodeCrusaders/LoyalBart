<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HuntController;
use App\Http\Controllers\InitiateBarterController;
use App\Http\Controllers\LoyaltyProgramController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/loyalty-programs')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'loyalty-programs', 'as' => 'loyalty-programs.'], function () {
        Route::get('/', [LoyaltyProgramController::class, 'index'])->name('index');
        Route::get('{program}', [LoyaltyProgramController::class, 'show'])->name('show');
    });

    Route::post('barter/initiate', InitiateBarterController::class)->name('barter.initiate');

    Route::get('hunts', [HuntController::class, 'index'])->name('hunts.index');

    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
});

Route::get('login', [AuthController::class, 'show'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthController::class, 'store'])->middleware('guest');
