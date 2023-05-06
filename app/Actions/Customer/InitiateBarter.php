<?php

namespace App\Actions\Customer;

use App\Models\Barter;
use App\Models\LoyaltyProgram;
use App\Models\User;

class InitiateBarter
{
    public function handle(
        User $initiator,
        LoyaltyProgram $OfferedProgram,
        int $offeredPoints,
        LoyaltyProgram $requestedProgram,
        int $requestedPoints
    ): Barter {
        $program = $initiator->loyaltyPrograms()->find($OfferedProgram->id);

        if (! $program || $program->pivot->points < $offeredPoints) {
            throw new \Exception('User dont have enough points to barter.');
        }

        $barter = $initiator->initiatedBarters()->create([
            'offered_program_id' => $OfferedProgram->id,
            'offered_points' => $offeredPoints,
            'requested_program_id' => $requestedProgram->id,
            'requested_points' => $requestedPoints,
        ]);

        return $barter;
    }
}
