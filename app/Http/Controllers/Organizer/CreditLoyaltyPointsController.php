<?php

namespace App\Http\Controllers\Organizer;

use App\Actions\CreditPointsToParticipant;
use App\Http\Controllers\Controller;
use App\Models\LoyaltyProgram;
use App\Models\User;

class CreditLoyaltyPointsController extends Controller
{
    public function __invoke(LoyaltyProgram $program)
    {
        app()->make(CreditPointsToParticipant::class)->handle(
            $program,
            User::where('uuid', request('user'))->first(),
            request('points'),
        );

        session()->flash('success', 'Points credited successfully.');

        return back();
    }
}
