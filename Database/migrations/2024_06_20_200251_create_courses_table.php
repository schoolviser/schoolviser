<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            // Unique identifier for integrations
            $table->uuid()->unique()->nullable();

            // Course name, scoped by company
            $table->string('name');
            $table->string('decription')->nullable();

            // Abbreviation, e.g. "BSc CS"
            $table->string('abbr')->nullable();

            // Award type, e.g. "Bachelor of Science", "Diploma"
            $table->string('award')->nullable();

            // Duration in years
            $table->unsignedInteger('duration')->nullable();

            // Flexible metadata (JSON or serialized configs)
            $table->text('meta')->nullable();

            // Scope
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('company_id');

            $table->timestamps();

            // Constraints
            $table->unique(['company_id', 'name'], 'unique_company_course');
            $table->unique(['company_id', 'abbr'], 'unique_company_course_abbr');
            $table->unique(['company_id', 'award'], 'unique_company_course_award');

            // Foreign keys
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

             $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('course_units', function (Blueprint $table) {
            $table->id();

            // Unique identifier for integrations
            $table->uuid()->unique()->nullable();

            // Unit name, scoped by course + company
            $table->string('name');

            // Unit code, e.g. "CSC101"
            $table->string('code')->nullable();

            // Year and semester within the course
            $table->enum('year', ['1','2','3','4'])->default('1');
            $table->enum('semester', ['1','2','3'])->default('1');

            $table->text('description')->nullable();
            $table->text('meta')->nullable();

            // Scope
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('company_id');

            $table->timestamps();

            // Constraints
            $table->unique(['company_id', 'course_id', 'name'], 'unique_course_unit_name');
            $table->unique(['company_id', 'course_id', 'code'], 'unique_course_unit_code');

            // Foreign keys
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_units');
        Schema::dropIfExists('courses');

    }
}
