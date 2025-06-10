<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class UpdateMcqOptionsSeeder extends Seeder
{
    public function run(): void
    {
        $question = Question::where('question_type', 'mcq')->first();
        if ($question) {
            $question->options = json_encode([
                'Apple',
                'Car',
                'Banana',
                'Dog'
            ]);
            $question->save();
        }
    }
} 