<?php

use App\Models\LoyaltyProgram;
use App\Models\Participant;
use App\Models\User;

class RedeemPointsForParticipant
{
    public function handle(
        LoyaltyProgram $program,
        User $participant,
        int $points
    ) {
        $participantData = Participant::query()->where([
            'participant_id' => $participant->id,
            'loyalty_program_id' => $program->id,
        ])->first();

        if (! $participantData || $participantData->points < $points) {
            throw new Exception('Participant don\'t have enough points');
        }

        $participantData->update([
            'points' => $participantData->points - $points,
        ]);

        return $participantData;
    }
}
