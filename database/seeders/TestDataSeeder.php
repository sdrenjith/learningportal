<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Day;
use App\Models\Question;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course = Course::first() ?? Course::create(['name' => 'English Basics']);

        Subject::updateOrCreate(['type' => 'listening'], [
            'name' => 'Listening',
            'type' => 'listening',
            'course_id' => $course->id,
        ]);
        Subject::updateOrCreate(['type' => 'writing'], [
            'name' => 'Writing',
            'type' => 'writing',
            'course_id' => $course->id,
        ]);
        Subject::updateOrCreate(['type' => 'reading'], [
            'name' => 'Reading',
            'type' => 'reading',
            'course_id' => $course->id,
        ]);
        Subject::updateOrCreate(['type' => 'speaking'], [
            'name' => 'Speaking',
            'type' => 'speaking',
            'course_id' => $course->id,
        ]);
    }
}
