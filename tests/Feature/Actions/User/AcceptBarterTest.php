<?php

namespace Tests\Feature\Actions\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Barter;
use App\Models\LoyaltyProgram;
use App\Actions\Customer\AcceptBarter;
use App\Actions\Customer\InitiateBarter;
use App\Actions\CreditPointsToParticipant;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AcceptBarterTest extends TestCase
{
    use RefreshDatabase;

    public function test_barter_system_works_as_expected(): void
    {
        $initiator = User::factory()->create();
        $acceptor = User::factory()->create();

        $organizer = User::factory()->create([
            'is_organizer' => true,
        ]);

        $offeredProgram = LoyaltyProgram::factory()->create([
            'organizer_id' => $organizer->id,
        ]);

        $requestedProgram = LoyaltyProgram::factory()->create([
            'organizer_id' => $organizer->id,
        ]);

        app()->make(CreditPointsToParticipant::class)->handle(
            $offeredProgram,
            $initiator,
            100
        );

        app()->make(CreditPointsToParticipant::class)->handle(
            $requestedProgram,
            $acceptor,
            100
        );

        app()->make(InitiateBarter::class)->handle(
            $initiator,
            $offeredProgram,
            10,
            $requestedProgram,
            20,
        );

        $barter = Barter::query()
            ->where([
                'initiator_id' => $initiator->id,
                'offered_program_id' => $offeredProgram->id,
                'offered_points' => 10,
                'requested_program_id' => $requestedProgram->id,
                'requested_points' => 20,
                'acceptor_id' => null,
                'accepted_at' => null,
            ])
            ->first();

        $this->assertNotNull($barter);

        app()->make(AcceptBarter::class)->handle(
            $barter,
            $acceptor,
        );

        $this->assertEquals($barter->refresh()->acceptor_id, $acceptor->id);
        $this->assertNotNull($barter->refresh()->accepted_at);

        $this->assertTrue(
            Participant::query()
                ->where([
                    'participant_id' => $initiator->id,
                    'loyalty_program_id' => $offeredProgram->id,
                    'points' => 90,
                ])
                ->exists()
        );

        $this->assertTrue(
            Participant::query()
                ->where([
                    'participant_id' => $initiator->id,
                    'loyalty_program_id' => $requestedProgram->id,
                    'points' => 20,
                ])
                ->exists()
        );

        $this->assertTrue(
            Participant::query()
                ->where([
                    'participant_id' => $acceptor->id,
                    'loyalty_program_id' => $offeredProgram->id,
                    'points' => 10,
                ])
                ->exists()
        );

        $this->assertTrue(
            Participant::query()
                ->where([
                    'participant_id' => $acceptor->id,
                    'loyalty_program_id' => $requestedProgram->id,
                    'points' => 80,
                ])
                ->exists()
        );
    }
}
