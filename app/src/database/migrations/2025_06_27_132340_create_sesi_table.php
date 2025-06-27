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
        Schema::create('sesi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses');
            $table->foreignId('teacher_id')->constrained('users');
            $table->integer('session_number');
            $table->enum('session_type', ['theory', 'assignment']);
            $table->enum('delivery_method', ['online', 'offline']);
            $table->date('session_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('online_link')->nullable();
            $table->foreignId('branch_office_id')->nullable()->constrained('branch_offices');
            $table->foreignId('syllabus_id')->constrained('syllabi');
            $table->enum('status', ['scheduled', 'completed', 'canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi');
    }
};
