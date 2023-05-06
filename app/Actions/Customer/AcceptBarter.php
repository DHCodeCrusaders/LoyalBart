<?php

namespace App\Actions\Customer;

use App\Actions\CreditPointsToParticipant;
use App\Actions\DeductPointsFromParticipant;
use App\Models\Barter;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AcceptBarter
{
    public function handle(
        Barter $barter,
        User $acceptor
    ): void {
        if ($barter->hasExpired()) {
            throw new \Exception('Barter has expired.');
        }

        if ($barter->initiator_id === $acceptor->id) {
            throw new \Exception('You cannot accept your own barter.');
        }

        $initiatorParticipantData = Participant::query()->where([
            'participant_id' => $barter->initiator_id,
            'loyalty_program_id' => $barter->offered_program_id,
        ])->first();

        if (!$initiatorParticipantData || $initiatorParticipantData->points < $barter->offered_points) {
            throw new \Exception("Initiator don't have enough points to barter.");
        }

        $acceptorParticipantData = Participant::query()->where([
            'participant_id' => $acceptor->id,
            'loyalty_program_id' => $barter->requested_program_id,
        ])->first();

        if (!$acceptorParticipantData || $acceptorParticipantData->points < $barter->requested_points) {
            throw new \Exception("Acceptor don't have enough points to barter.");
        }

        DB::transaction(function () use ($acceptor, $barter) {
            $barter->update([
                'acceptor_id' => $acceptor->id,
                'accepted_at' => now(),
            ]);

            app()->make(DeductPointsFromParticipant::class)->handle(
                $barter->offeredProgram,
                $barter->initiator,
                $barter->offered_points
            );

            app()->make(CreditPointsToParticipant::class)->handle(
                $barter->offeredProgram,
                $barter->acceptor,
                $barter->offered_points
            );

            app()->make(CreditPointsToParticipant::class)->handle(
                $barter->requestedProgram,
                $barter->initiator,
                $barter->requested_points
            );

            app()->make(DeductPointsFromParticipant::class)->handle(
                $barter->requestedProgram,
                $barter->acceptor,
                $barter->requested_points
            );

            // TODO: check if initiator/acceptor has other active barters with same program and invalidate them if necessary
        });

        // TODO: notify initiator about the barter
    }
}
