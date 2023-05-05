<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['First', 'Second', 'Third', 'Fourth', 'Firth'] as $idx => $position) {
            $index = $idx+1;

            \App\Models\User::factory()->create([
                'name' => $position . ' Customer',
                'email' => "customer{$index}@email.com",
            ]);

            \App\Models\User::factory()->create([
                'name' => $position . ' Organiser',
                'email' => "organiser{$index}@email.com",
            ]);
        }


    }
}
