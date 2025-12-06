<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('location_id')
                ->nullable()
                ->unique()
                ->after('id');
        });

        DB::table('locations')
            ->orderBy('id')
            ->lazy()
            ->each(function ($location) {
                $locationId = sprintf('LOC-%04d', $location->id);

                DB::table('locations')
                    ->where('id', $location->id)
                    ->update([
                        'location_id' => $locationId,
                        'updated_at' => now(),
                    ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('location_id');
        });
    }
};

