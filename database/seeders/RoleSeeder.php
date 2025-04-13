<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();
        Role::insert([
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Doctor',
            ],
            [
                'name' => 'Patient',
            ]
        ]);
    }
}
