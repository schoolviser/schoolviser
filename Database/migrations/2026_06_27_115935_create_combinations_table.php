<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combinations', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();

            $table->string('name'); // e.g. "PCM"
            $table->string('description')->nullable(); // e.g. "Physics, Chemistry, Mathematics"
            $table->unsignedBigInteger('company_id'); // tenant scope

            // Subsidiary subjects (max 3)
            $table->unsignedBigInteger('subsidiary1_id')->nullable();
            $table->unsignedBigInteger('subsidiary2_id')->nullable();
            $table->unsignedBigInteger('subsidiary3_id')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('subsidiary1_id')->references('id')->on('subjects')->onDelete('set null');
            $table->foreign('subsidiary2_id')->references('id')->on('subjects')->onDelete('set null');
            $table->foreign('subsidiary3_id')->references('id')->on('subjects')->onDelete('set null');
        });

        // Pivot table for principal subjects
        Schema::create('combination_subject', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('combination_id');
            $table->unsignedBigInteger('subject_id');

            $table->foreign('combination_id')->references('id')->on('combinations')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combination_subject');
        Schema::dropIfExists('combinations');
    }
};
