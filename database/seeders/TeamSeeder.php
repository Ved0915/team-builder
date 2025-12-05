<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::insert([
            [
                'name' => 'Red Warriors',
                'state' => 'Rajasthan',
                'country' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blue Dragons',
                'state' => 'Maharashtra',
                'country' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Green Knights',
                'state' => 'Gujarat',
                'country' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'White Tigers',
                'state' => 'Punjab',
                'country' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Black Panthers',
                'state' => 'Karnataka',
                'country' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Golden Eagles',
                'state' => 'Delhi',
                'country' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Silver Sharks',
                'state' => 'Tamil Nadu',
                'country' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Orange Falcons',
                'state' => 'Uttar Pradesh',
                'country' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
