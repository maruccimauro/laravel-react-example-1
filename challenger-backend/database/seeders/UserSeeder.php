<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(20)->create(['role' => 'teacher']);
        User::factory()->count(800)->create(['role' => 'student']);

        User::factory()->create([
            "name" => "teacher",
            "role" => "teacher",
            "email" => "teacher@gmail.com",
            "password" => Hash::make('123456789'),

        ]);
        User::factory()->create([
            "name" => "student",
            "role" => "student",
            "email" => "student@gmail.com",
            "password" => Hash::make('123456789'),
        ]);
    }
}
