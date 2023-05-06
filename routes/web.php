<?php

use App\Actions\Customer\InitiateBarter;
use App\Models\Barter;
use App\Models\LoyaltyProgram;
use App\Models\Participant;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/loyalty-programs')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/loyalty-programs', function () {
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
    })->name('loyalty-programs.index');

    Route::get('/loyalty-programs/{program}', function (LoyaltyProgram $program) {
        return Inertia::render('LoyaltyProgram/Show', [
            'program' => LoyaltyProgram::find($program->id),
            'participation_data' => Participant::query()
                ->where('participant_id', Auth::id())
                ->where('loyalty_program_id', $program->id)
                ->first(),
            'programs' => LoyaltyProgram::query()
                ->pluck('title', 'id'),
            'barters' => Barter::query()
                ->active()
                ->where(
                    fn ($q) => $q->where('offered_program_id', $program->id)->orWhere('offered_program_id', $program->id)
                )
                ->with(['initiator', 'offeredProgram', 'requestedProgram'])
                ->get()
        ]);
    })->name('loyalty-programs.show');

    Route::post('/barter/initiate', function () {
        $data = request()->validate([
            'offered_program_id' => 'required|exists:loyalty_programs,id',
            'requested_program_id' => 'required|exists:loyalty_programs,id',
            'requested_points' => 'required|integer|min:1',
            'offered_points' => 'required|integer|min:1',
        ]);

        try {
            app()->make(InitiateBarter::class)->handle(
                Auth::user(),
                LoyaltyProgram::find($data['offered_program_id']),
                $data['offered_points'],
                LoyaltyProgram::find($data['requested_program_id']),
                $data['requested_points'],
            );

            session(['success' => 'Barter initiated successfully..']);

            return "Fuck you!";
        } catch (\Exception $e) {
            session(['error' => $e->getMessage()]);
        }

        return back();  
        
    })->name('barter.initiate');

    Route::get('/');
});

Route::get('login', function () {
    return Inertia::render('Auth/Login', []);
})->name('login')->middleware('guest');

Route::post('login', function () {
    Auth::login(User::first());

    return to_route('home');
})->middleware('guest');
