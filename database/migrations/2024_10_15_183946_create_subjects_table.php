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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name')->nullable()->unique();
            $table->string('short_code')->nullable();
            $table->enum('level', ['o','a'])->default('o');
            $table->enum('compulsory', ['1','0'])->default('0');

            $table->text('meta')->nullable();

            $table->unique(['name', 'level'], 'unique_subject_level');
            $table->unique(['short_code', 'level'], 'unique_subject_level_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
