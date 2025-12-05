<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Player;


class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Player::insert([
            [
                'name' => 'Virat Sharma',
                'email' => 'virat@example.com',
                'date_of_birth' => '1992-01-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rohit Mehta',
                'email' => 'rohit@example.com',
                'date_of_birth' => '1990-05-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aman Gupta',
                'email' => 'aman@example.com',
                'date_of_birth' => '1995-03-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sanjay Patel',
                'email' => 'sanjay@example.com',
                'date_of_birth' => '1993-07-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Deepak Joshi',
                'email' => 'deepak@example.com',
                'date_of_birth' => '1996-11-11',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kunal Deshmukh',
                'email' => 'kunal@example.com',
                'date_of_birth' => '1991-09-09',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pranav Kulkarni',
                'email' => 'pranav@example.com',
                'date_of_birth' => '1994-12-18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Meera Iyer',
                'email' => 'meera@example.com',
                'date_of_birth' => '1993-04-07',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arjun Narang',
                'email' => 'arjun@example.com',
                'date_of_birth' => '1997-08-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Neha Reddy',
                'email' => 'neha@example.com',
                'date_of_birth' => '1992-10-02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ishaan Verma',
                'email' => 'ishaan@example.com',
                'date_of_birth' => '1998-02-14',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ritika Malhotra',
                'email' => 'ritika@example.com',
                'date_of_birth' => '1991-06-22',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sameer Khanna',
                'email' => 'sameer@example.com',
                'date_of_birth' => '1993-09-03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ananya Bhat',
                'email' => 'ananya@example.com',
                'date_of_birth' => '1995-12-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kabir Sethi',
                'email' => 'kabir@example.com',
                'date_of_birth' => '1990-08-19',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
