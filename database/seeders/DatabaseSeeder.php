<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\LoyaltyProgram;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['First', 'Second', 'Third', 'Fourth', 'Firth'] as $idx => $position) {
            $index = $idx + 1;

            \App\Models\User::factory()->create([
                'name' => $position . ' Customer',
                'email' => "customer{$index}@email.com",
                'is_organizer' => false,
            ]);

            $organizer = \App\Models\User::factory()->create([
                'name' => $position . ' organizer',
                'email' => "organizer{$index}@email.com",
                'is_organizer' => true,
            ]);

            LoyaltyProgram::factory(random_int(1, 2))->create([
                'organizer_id' => $organizer->id,
            ]);
        }

        $loyaltyPrograms = LoyaltyProgram::query()->get();

        User::query()->get()->each(function (User $user) use ($loyaltyPrograms) {
            Participant::query()->create([
                'participant_id' => $user->id,
                'loyalty_program_id' => $loyaltyPrograms->random()->id,
                'points' => random_int(0, 100),
            ]);
        });
    }
}
