<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('education_backgrounds', function (Blueprint $table) {
            if (Schema::hasColumn('education_backgrounds', 'certification')) {
                $table->renameColumn('certification', 'qualification');
                $table->text('meta')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('education_backgrounds', function (Blueprint $table) {
            if (Schema::hasColumn('education_backgrounds', 'qualification')) {
                $table->renameColumn('qualification', 'certification');
                $table->text('meta')->nullable(false)->change();
            }
        });
    }
};

