<?php

namespace App\Http\Controllers\Organizer;

use App\Models\User;
use App\Models\LoyaltyProgram;
use App\Http\Controllers\Controller;
use App\Actions\DeductPointsFromParticipant;

class RedeemPointsController extends Controller
{
    public function __invoke(LoyaltyProgram $program)
    {
        try {
            app()->make(DeductPointsFromParticipant::class)->handle(
                $program,
                User::where('uuid', request('user'))->first(),
                request('points'),
            );

            session()->flash('success', 'Points redeemed successfully.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return back();
    }
}
