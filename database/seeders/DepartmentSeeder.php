<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::truncate();

        Department::insert([
            ['name' => 'General Medicine'],
            ['name' => 'Cardiology'],
            ['name' => 'Orthopedics'],
            ['name' => 'Pediatrics'],
            ['name' => 'Emergency Medicine'],
            ['name' => 'Radiology'],
            ['name' => 'Surgery'],
            ['name' => 'Pathology'],
            ['name' => 'Oncology'],
        ]);
    }
}
