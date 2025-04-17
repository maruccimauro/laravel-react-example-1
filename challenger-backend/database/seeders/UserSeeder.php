<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "teacher",
            "role" => "teacher",
            "email" => "teacher@gmail.com",

        ]);
        User::factory()->create([
            "name" => "student",
            "role" => "student",
            "email" => "student@gmail.com",
        ]);
        User::factory()->count(20)->create(['role' => 'teacher']);
        User::factory()->count(800)->create(['role' => 'student']);
    }
}
