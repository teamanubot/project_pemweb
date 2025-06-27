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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('leave_type', ['annual', 'sick', 'personal']);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('number_of_days', 5, 1);
            $table->text('reason');
            $table->string('proof_file_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('replacement_user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
