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
        Schema::table('days', function (Blueprint $table) {
            $table->dropColumn('day_number');
            $table->date('date')->nullable()->after('title');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null')->after('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('days', function (Blueprint $table) {
            $table->integer('day_number')->nullable();
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
            $table->dropColumn('date');
        });
    }
};
