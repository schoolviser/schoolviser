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
        if (!Schema::hasTable('options')){
            Schema::create('options', function (Blueprint $table) {
                $table->id('id');
                $table->string('key');
                $table->text('value')->nullable();
                $table->string('group');
                $table->timestamps();
                $table->unique(['key','group'], 'unique_settings');
            });
        }
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
