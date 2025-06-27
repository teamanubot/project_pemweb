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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('course_id')->constrained('courses');
            $table->decimal('quiz_assignment_score', 5, 2)->nullable();
            $table->decimal('attendance_percentage', 5, 2)->nullable();
            $table->decimal('mid_eval_score', 5, 2)->nullable();
            $table->decimal('final_eval_score', 5, 2)->nullable();
            $table->decimal('project_score', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->boolean('is_passed')->default(false);
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
