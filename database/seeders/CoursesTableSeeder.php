<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = ['A1', 'A2', 'B1', 'B2'];
        foreach ($courses as $name) {
            Course::firstOrCreate(['name' => $name]);
        }
    }
}
