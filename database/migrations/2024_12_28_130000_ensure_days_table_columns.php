<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure days table has all required columns
        if (Schema::hasTable('days')) {
            Schema::table('days', function (Blueprint $table) {
                // Add day_number if it doesn't exist
                if (!Schema::hasColumn('days', 'day_number')) {
                    $table->integer('day_number')->nullable();
                }
                
                // Add course_id if it doesn't exist
                if (!Schema::hasColumn('days', 'course_id')) {
                    $table->unsignedBigInteger('course_id')->nullable();
                }
                
                // Add title if it doesn't exist
                if (!Schema::hasColumn('days', 'title')) {
                    $table->string('title')->nullable();
                }
            });
        } else {
            // Create the table if it doesn't exist
            Schema::create('days', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->integer('day_number')->nullable();
                $table->string('title')->nullable();
                $table->unsignedBigInteger('course_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't remove columns in down() to prevent data loss
    }
}; 