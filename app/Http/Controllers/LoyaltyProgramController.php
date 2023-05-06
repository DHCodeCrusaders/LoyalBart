<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Barter;
use App\Models\Participant;
use App\Models\LoyaltyProgram;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoyaltyProgramController extends Controller
{
    public function index()
    {
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
    }

    public function show(LoyaltyProgram $program)
    {
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
                ->orderBy('created_at', 'desc')
                ->get()
        ]);
    }
}
