<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Title;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'firstname' => 'Ali',
                'lastname' => 'Alavi',
                'nickname' => 'Admin',
                'role' => 'super_admin',
                'unit' => 'dev',
                'email_hash' => hash('sha256', 'admin@example.com'),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'status' => 'active'
            ]
        );

        User::factory(10)->create();
        Title::factory(3)->create();        
        Task::factory(10)->create();        
    }
}