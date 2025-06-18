<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop and recreate the days table with all required columns
        Schema::dropIfExists('days');
        
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('day_number');
            $table->string('title')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('days');
    }
}; 