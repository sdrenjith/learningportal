<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('questions');
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('question_type_id');
            $table->unsignedBigInteger('course_id');
            $table->foreignId('test_id')->nullable()->constrained('tests')->onDelete('set null');
            $table->string('instruction');
            $table->json('question_data')->nullable();
            $table->json('answer_data')->nullable();
            $table->integer('points')->nullable()->default(1);
            $table->text('explanation')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}; 