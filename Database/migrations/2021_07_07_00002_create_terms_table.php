<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            // Term number (1–4) or semester
            $table->enum('term', ['1','2','3','4'])->default('1');

            // Defines the span of the term
            $table->date('start_date');
            $table->date('end_date');

            $table->date('registration_deadline')->nullable();
            $table->date('exam_start_date')->nullable();
            $table->date('exam_end_date')->nullable();
            $table->date('results_release_date')->nullable();

            $table->enum('lock_registration', ['open','closed'])->default('open');
            $table->integer('max_allowed_registrations')->nullable();
            $table->enum('lock_grades', ['open','closed'])->default('open');

            $table->string('status')->default('active');

            // Planning field for continuity
            $table->date('next_term_start_date')->nullable();

            // JSON metadata (exam schedules, notes, configs)
            $table->longText('meta')->nullable();

            // Reference to academic year
            $table->unsignedBigInteger('academic_year_id');

            // Quick stats for dashboards
            $table->unsignedInteger('total_students')->default(0);
            $table->unsignedInteger('total_classes')->default(0);

            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            // Uniqueness: one term per academic year
            $table->unique(['academic_year_id', 'term'], 'unique_term_year');

            // Audit trail
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Foreign keys
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terms');
    }
}
