<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('terms', function (Blueprint $table) {
            // Check if the column does not exist before adding
            if (!Schema::hasColumn('terms', 'uuid')) {
                // Add the uuid column
                $table->uuid('uuid')->after('id')->unique()->nullable();
            }
        });

        // Populate the UUIDs for existing records (if needed)
        DB::table('terms')->get()->each(function ($course) {
            if (empty($course->uuid)) {
                DB::table('terms')
                    ->where('id', $course->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('terms', function (Blueprint $table) {
            if (Schema::hasColumn('terms', 'uuid')) {
                $table->dropColumn('uuid');
            }
        });
    }
};
