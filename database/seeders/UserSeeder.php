<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@grievance.gov.in',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $departments = Department::all();

        foreach ($departments as $i => $dept) {
            User::create([
                'name' => "Officer {$dept->name}",
                'email' => "officer." . $dept->slug . "@grievance.gov.in",
                'password' => Hash::make('password'),
                'role' => 'officer',
                'department_id' => $dept->id,
                'is_active' => true,
            ]);
        }

        User::create([
            'name' => 'Citizen Demo',
            'email' => 'citizen@example.com',
            'password' => Hash::make('password'),
            'phone' => '9876543210',
            'role' => 'citizen',
            'is_active' => true,
        ]);
    }
}
