<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combination_subjects', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();

            $table->unsignedBigInteger('combination_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('company_id'); // tenant scope

            $table->timestamps();

            // Foreign keys
            $table->foreign('combination_id')->references('id')->on('combinations')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Prevent duplicate subject assignment in same combination
            $table->unique(['combination_id','subject_id','company_id'], 'uniq_combination_subject');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combination_subject');
    }
};
