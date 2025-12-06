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
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('location_id')
                ->nullable()
                ->after('room_no')
                ->constrained('locations')
                ->nullOnDelete();

            $table->foreignId('room_type_id')
                ->nullable()
                ->after('location_id')
                ->constrained('room_types')
                ->nullOnDelete();

            $table->decimal('base_rate', 10, 2)
                ->default(0)
                ->after('description');

            $table->string('occupancy_status')
                ->default('empty')
                ->after('room_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropConstrainedForeignId('location_id');
            $table->dropConstrainedForeignId('room_type_id');
            $table->dropColumn(['base_rate', 'occupancy_status']);
        });
    }
};

