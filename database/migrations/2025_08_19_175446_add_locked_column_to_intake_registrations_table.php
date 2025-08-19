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
        Schema::table('intake_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('intake_registrations', 'locked')) {
                $table->boolean('locked')->default(false)->after('id'); 
                // you can replace 'id' with the column after which you want it
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('intake_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('intake_registrations', 'locked')) {
                $table->dropColumn('locked');
            }
        });
    }
};
