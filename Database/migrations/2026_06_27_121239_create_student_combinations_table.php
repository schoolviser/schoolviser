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
        // Combination history incase student hanges it
        Schema::create('student_combinations', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('combination_id');
            $table->unsignedBigInteger('clazz_id'); // S5 or S6
            $table->unsignedBigInteger('term_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('company_id');

            $table->timestamps();

            // Foreign keys
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('combination_id')->references('id')->on('combinations')->onDelete('cascade');
            $table->foreign('clazz_id')->references('id')->on('clazzs')->onDelete('cascade');
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Audit trail
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_combinations');
    }
};
