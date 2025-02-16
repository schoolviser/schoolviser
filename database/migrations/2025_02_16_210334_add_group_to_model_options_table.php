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
        if (!Schema::hasColumn('model_options', 'group')) {
            Schema::table('model_options', function (Blueprint $table) {
                $table->string('group')->nullable()->after('value'); // Add column after 'value'
                $table->unique(['key', 'group'], 'unique_group_option'); // Ensure unique key-group pair
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('model_options', 'group')) {
            Schema::table('model_options', function (Blueprint $table) {
                $table->dropUnique('unique_group_option'); // Drop unique constraint first
                $table->dropColumn('group'); // Then remove the column
            });
        }
    }
};
