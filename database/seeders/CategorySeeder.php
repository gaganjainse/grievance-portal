<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Road Damage', 'department' => 'Municipal Corporation', 'days' => 7],
            ['name' => 'Street Light Not Working', 'department' => 'Municipal Corporation', 'days' => 3],
            ['name' => 'Garbage Not Collected', 'department' => 'Municipal Corporation', 'days' => 2],
            ['name' => 'Sewage Overflow', 'department' => 'Municipal Corporation', 'days' => 3],
            ['name' => 'Hospital Services', 'department' => 'Public Health', 'days' => 5],
            ['name' => 'Disease Outbreak', 'department' => 'Public Health', 'days' => 1],
            ['name' => 'School Infrastructure', 'department' => 'Education', 'days' => 10],
            ['name' => 'Teacher Availability', 'department' => 'Education', 'days' => 7],
            ['name' => 'Theft / Robbery', 'department' => 'Police & Law Enforcement', 'days' => 3],
            ['name' => 'Traffic Issue', 'department' => 'Police & Law Enforcement', 'days' => 2],
            ['name' => 'Water Shortage', 'department' => 'Water Supply', 'days' => 2],
            ['name' => 'Pipe Leakage', 'department' => 'Water Supply', 'days' => 3],
            ['name' => 'Power Outage', 'department' => 'Electricity', 'days' => 1],
            ['name' => 'Voltage Fluctuation', 'department' => 'Electricity', 'days' => 3],
            ['name' => 'Bus Service Issue', 'department' => 'Transport', 'days' => 5],
            ['name' => 'Pension Not Received', 'department' => 'Social Welfare', 'days' => 10],
        ];

        foreach ($categories as $cat) {
            $dept = Department::where('name', $cat['department'])->first();
            if ($dept) {
                Category::create([
                    'name' => $cat['name'],
                    'slug' => str()->slug($cat['name']),
                    'department_id' => $dept->id,
                    'escalation_days' => $cat['days'],
                ]);
            }
        }
    }
}
