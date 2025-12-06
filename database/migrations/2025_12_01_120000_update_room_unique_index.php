<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (Schema::hasColumn('rooms', 'location_id')) {
                $table->dropUnique('rooms_location_type_no_unique');
            }

            $table->unique(['room_type_id', 'room_no'], 'rooms_type_no_unique');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropUnique('rooms_type_no_unique');
            $table->unique(['location_id', 'room_type_id', 'room_no'], 'rooms_location_type_no_unique');
        });
    }
};

