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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('room_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('room_type_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            // Guest information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number', 30);
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('id_proof_type', 50);
            $table->string('id_number');

            // Room information
            $table->string('location', 50);
            $table->string('room_status', 30);
            $table->string('occupancy_status', 30);
            $table->text('additional_description')->nullable();

            // Stay details
            $table->string('booking_type', 30);
            $table->dateTime('check_in_at');
            $table->dateTime('check_out_at');
            $table->unsignedTinyInteger('guest_count');

            // Payment & charges
            $table->decimal('room_rate', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('service_charges', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_type', 30);
            $table->string('payment_status', 30)->default('pending');
            $table->text('payment_details')->nullable();

            // Booking management
            $table->boolean('is_repeat_customer')->default(false);
            $table->text('notes')->nullable();
            $table->string('booking_status', 30)->default('pending');

            $table->timestamps();

            $table->index('booking_status');
            $table->index('payment_status');
            $table->index('room_id');
            $table->index('room_type_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};


