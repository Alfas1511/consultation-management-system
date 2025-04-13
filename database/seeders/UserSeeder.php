<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
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
        User::truncate();
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin@gmail.com',
            'role_id' => 1,
            'password' => Hash::make(12345678),
        ]);

        User::create([
            'name' => 'Doctor',
            'email' => 'doctor@gmail.com',
            'username' => 'doctor@gmail.com',
            'role_id' => 2,
            'password' => Hash::make(12345678),
        ]);

        User::create([
            'name' => 'Patient',
            'email' => 'patient@gmail.com',
            'username' => 'patient@gmail.com',
            'role_id' => 3,
            'password' => Hash::make(12345678),
        ]);

    }
}
