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
        Schema::create('course_groups', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();
            $table->string('short_code', 10)->nullable();
            $table->string('name'); // eg BSCS Class of 2020
            $table->text('description')->nullable();
            $table->enum('graduated', ['1', '0'])->default('0');
            $table->date('completes_on')->nullable();
            $table->enum('active', ['1','0'])->default('0');

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');

            $table->unsignedBigInteger('term_id')->nullable(); // when it was created
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('set null');
            $table->unsignedBigInteger('academic_year_id')->nullable(); // when it was created
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');

             $table->unique(['name', 'company_id', 'term_id', 'course_id'], 'uniq_course_group');
            $table->unique(['short_code', 'company_id', 'term_id'], 'uniq_short_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_groups');
    }
};
