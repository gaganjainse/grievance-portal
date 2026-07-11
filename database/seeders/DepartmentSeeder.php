<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Municipal Corporation', 'slug' => 'municipal-corporation', 'description' => 'City infrastructure, roads, sanitation'],
            ['name' => 'Public Health', 'slug' => 'public-health', 'description' => 'Health services, hospitals, disease control'],
            ['name' => 'Education', 'slug' => 'education', 'description' => 'Schools, colleges, educational affairs'],
            ['name' => 'Police & Law Enforcement', 'slug' => 'police', 'description' => 'Law and order, traffic, safety'],
            ['name' => 'Water Supply', 'slug' => 'water-supply', 'description' => 'Drinking water, irrigation, pipelines'],
            ['name' => 'Electricity', 'slug' => 'electricity', 'description' => 'Power supply, electrical infrastructure'],
            ['name' => 'Transport', 'slug' => 'transport', 'description' => 'Public transport, roads, bridges'],
            ['name' => 'Social Welfare', 'slug' => 'social-welfare', 'description' => 'Social schemes, pensions, welfare programs'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
