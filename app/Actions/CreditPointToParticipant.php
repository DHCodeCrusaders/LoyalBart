<?php

namespace App\Actions;

use App\Models\LoyaltyProgram;
use App\Models\LoyaltyProgramParticipant;
use App\Models\User;

class CreditPointToParticipant
{
    public function handle(LoyaltyProgram $program, User $user, int $points): void
    {
        $participantData = LoyaltyProgramParticipant::where([
            'participant_id' => $user->id,
            'loyalty_program_id' => $program->id,
        ])->first();

        if (! $participantData) {
            $program->participants()->attach([$user->id => ['points' => $points]]);

            return;
        }

        $user->loyaltyPrograms()->updateExistingPivot($program->id, [
            'points' => $participantData->points + $points,
        ]);
    }
}
