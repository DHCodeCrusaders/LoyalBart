<?php

namespace App\Http\Controllers\Organizer;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LoyaltyProgram;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;

class LoyaltyProgramController extends Controller
{
    public function index()
    {
        return Inertia::render('Organizer/LoyaltyProgram/Index', [
            'programs' => Auth::user()->ownedLoyaltyPrograms()->orderBy('title')->get(),
        ]);
    }

    public function show(LoyaltyProgram $program)
    {
        return Inertia::render('Organizer/LoyaltyProgram/Show', [
            'program' => $program,
            'total_points' => Participant::where('loyalty_program_id', $program->id)
                ->sum('points'),
            'customers' => $program->participants()->orderBy('participants.points')->get(),
        ]);
    }
}
