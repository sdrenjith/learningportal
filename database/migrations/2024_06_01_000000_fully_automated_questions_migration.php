<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // The required enum values for question_types
    private $questionTypeEnums = [
        'mcq_single',
        'mcq_multiple',
        'reorder',
        'picture_mcq',
        'form_fill',
        'opinion',
        'statement_match',
    ];

    public function up(): void
    {
        // 0. Ensure all required foreign key tables exist FIRST
        // $this->ensureTable('days');
        $this->ensureTable('levels');
        $this->ensureTable('subjects');
        $this->ensureQuestionTypesTable();

        // 1. Ensure all required question_types exist
        foreach ($this->questionTypeEnums as $enum) {
            DB::table('question_types')->updateOrInsert(['name' => $enum], ['name' => $enum]);
        }

        // 2. Create the new questions table with the correct schema
        if (Schema::hasTable('questions_new')) {
            Schema::drop('questions_new');
        }
        Schema::create('questions_new', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_id');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('question_type_id');
            $table->string('instruction');
            $table->json('question_data');
            $table->json('answer_data');
            $table->integer('points')->nullable()->default(1);
            $table->text('explanation')->nullable();
            $table->json('left_options')->nullable();
            $table->json('right_options')->nullable();
            $table->json('correct_pairs')->nullable();
            $table->timestamps();

            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('question_type_id')->references('id')->on('question_types')->onDelete('cascade');
        });

        // 3. Migrate and map data from the old questions table (if it exists)
        if (Schema::hasTable('questions')) {
            $questions = DB::table('questions')->get();
            foreach ($questions as $q) {
                // Map old enum to question_type_id
                $questionTypeId = null;
                if (isset($q->question_type)) {
                    $questionTypeId = DB::table('question_types')->where('name', $q->question_type)->value('id');
                } elseif (isset($q->question_type_id)) {
                    $questionTypeId = $q->question_type_id;
                }
                // Fallbacks for missing data
                $levelId = $q->level_id ?? $q->course_id ?? 1;
                $dayId = $q->day_id ?? 1;
                $subjectId = $q->subject_id ?? 1;

                // Ensure referenced day exists
                if (!DB::table('days')->where('id', $dayId)->exists()) {
                    DB::table('days')->insert([
                        'id' => $dayId,
                        'name' => 'Auto-created Day #' . $dayId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                // Ensure referenced level exists
                if (!DB::table('levels')->where('id', $levelId)->exists()) {
                    DB::table('levels')->insert([
                        'id' => $levelId,
                        'name' => 'Auto-created Level #' . $levelId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                // Ensure referenced subject exists
                if (!DB::table('subjects')->where('id', $subjectId)->exists()) {
                    DB::table('subjects')->insert([
                        'id' => $subjectId,
                        'name' => 'Auto-created Subject #' . $subjectId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $instruction = $q->instruction ?? $q->question_text ?? '';
                $questionData = $q->question_data ?? json_encode(['question' => 'Auto-migrated', 'options' => []]);
                $answerData = $q->answer_data ?? json_encode(['correct_indices' => []]);
                $points = $q->points ?? $q->mark ?? 1;
                $explanation = $q->explanation ?? null;

                // Insert into new table
                DB::table('questions_new')->insert([
                    'id' => $q->id,
                    'day_id' => $dayId,
                    'level_id' => $levelId,
                    'subject_id' => $subjectId,
                    'question_type_id' => $questionTypeId ?? 1,
                    'instruction' => $instruction,
                    'question_data' => $questionData,
                    'answer_data' => $answerData,
                    'points' => $points,
                    'explanation' => $explanation,
                    'created_at' => $q->created_at ?? now(),
                    'updated_at' => $q->updated_at ?? now(),
                ]);
            }
            Schema::drop('questions');
        }

        // 4. Rename the new table
        Schema::rename('questions_new', 'questions');
    }

    public function down(): void
    {
        // Not implemented: restoring the old structure is not supported in this migration.
    }

    // Helper: Ensure a table exists (creates a minimal table if missing)
    private function ensureTable($table)
    {
        if (!Schema::hasTable($table)) {
            Schema::create($table, function (Blueprint $tableDef) use ($table) {
                $tableDef->id();
                // Add a name column for lookup tables
                if (in_array($table, ['levels', 'subjects', 'question_types'])) {
                    $tableDef->string('name')->unique();
                }
                $tableDef->timestamps();
            });
        }
    }

    // Helper: Ensure the question_types table exists and has a name column
    private function ensureQuestionTypesTable()
    {
        if (!Schema::hasTable('question_types')) {
            Schema::create('question_types', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->timestamps();
            });
        } else {
            // Add name column if missing
            if (!Schema::hasColumn('question_types', 'name')) {
                Schema::table('question_types', function (Blueprint $table) {
                    $table->string('name')->unique()->after('id');
                });
            }
        }
    }
}; 