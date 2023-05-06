<?php

namespace App\Actions;

use App\Models\LoyaltyProgram;
use App\Models\Participant;
use App\Models\User;

class DeductPointsFromParticipant
{
    public function handle(LoyaltyProgram $program, User $participant, int $points): void
    {
        $participantData = Participant::query()->where([
            'participant_id' => $participant->id,
            'loyalty_program_id' => $program->id,
        ])->first();

        if (! $participantData || $participantData->points < $points) {
            throw new \Exception("Customer don't have enough points.");
        }

        $participantData->update([
            'points' => $participantData->points - $points,
        ]);
    }
}
