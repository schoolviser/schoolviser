<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            // Human-readable label, e.g. "2026"
            $table->string('name');

            // Defines the span of the academic year
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // Useful for planning transitions
            $table->date('next_term_start_date')->nullable();

            // JSON or serialized metadata (settings, configs, notes)
            $table->json('meta')->nullable();

            // Quick reference statistics (populated via jobs/aggregations)
            $table->unsignedInteger('total_students')->default(0);
            $table->unsignedInteger('total_staff')->default(0);
            $table->unsignedInteger('total_classes')->default(0);

            // Status flags
            $table->boolean('is_active')->default(true); // current year indicator
            $table->boolean('is_locked')->default(false); // prevents edits after archival

            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            // Audit trail
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Constraints
            $table->unique(['company_id', 'name'], 'unique_company_year');


            // Foreign keys
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
        Schema::dropIfExists('academic_years');
    }
}
