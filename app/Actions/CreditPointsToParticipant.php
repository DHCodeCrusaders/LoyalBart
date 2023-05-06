<?php

namespace App\Actions;

use App\Models\LoyaltyProgram;
use App\Models\Participant;
use App\Models\User;

class CreditPointsToParticipant
{
    public function handle(LoyaltyProgram $program, User $participant, int $points): void
    {
        $participantData = Participant::query()->where([
            'participant_id' => $participant->id,
            'loyalty_program_id' => $program->id,
        ])->first();

        if (! $participantData) {
            Participant::query()->create([
                'participant_id' => $participant->id,
                'loyalty_program_id' => $program->id,
                'points' => $points,
            ]);

            return;
        }

        $participantData->update([
            'points' => $participantData->points + $points,
        ]);
    }
}
