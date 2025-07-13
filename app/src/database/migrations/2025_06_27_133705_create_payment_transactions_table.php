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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('course_enrollment_id')->constrained('course_enrollments');
            $table->string('midtrans_order_id')->unique();
            $table->string('midtrans_transaction_id')->nullable()->unique();
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('IDR');
            $table->string('payment_method');
            $table->enum('transaction_status', [
                'pending', 
                'settlement', 
                'expire', 
                'cancel', 
                'deny', 
                'refund', 
                'partial_refund', 
                'capture', 
                'authorize'
            ]);
            $table->timestamp('transaction_time');
            $table->timestamp('settlement_time')->nullable();
            $table->timestamp('expiry_time')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
