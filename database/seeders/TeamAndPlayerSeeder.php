<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Player;
use App\Models\User;

class TeamAndPlayerSeeder extends Seeder
{
    public function run()
    {
        // Ensure at least one admin user exists
        $adminUser = User::first() ?? User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $teamNames = [
            'Red Falcons', 'Blue Wolves', 'Green Hawks', 'Golden Lions',
            'Black Panthers', 'White Tigers', 'Silver Eagles', 'Yellow Hornets',
            'Orange Foxes', 'Purple Dragons'
        ];

        foreach ($teamNames as $teamName) {
            // Create team
            $team = Team::create([
                'name' => $teamName,
                'points' => 0,
                'creator_id' => $adminUser->id,
            ]);

            // Create 11 players for each team
            for ($i = 1; $i <= 11; $i++) {
                Player::create([
                    'name' => $teamName . ' Player ' . $i,
                    'team_id' => $team->id,
                    'user_id' => $adminUser->id, // works because column exists
                ]);
            }
        }
    }
}
