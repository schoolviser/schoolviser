<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntakeRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intake_registrations', function (Blueprint $table) {
            $table->id();

            // Unique identifier for external integrations or tracking
            $table->uuid()->unique()->nullable();

            // Boarding vs day students
            $table->enum('residence', ['boarding','day'])->default('boarding');

            // Whether student is new or continuing
            $table->enum('new_or_continuing', ['new','continuing'])->default('new');

            // Semester and year within the program
            $table->enum('semester', ['1','2','3','4','5'])->default('1');
            $table->enum('year', ['1','2','3','4','5'])->default('1');

            // Lock flag to prevent edits after approval
            $table->boolean('locked')->default(false);
            $table->boolean('retake')->default(false);

            // Registration date
            $table->date('registered_on')->nullable();

            // Financial fields
            $table->string('balance_carried_forward')->nullable(); // corrected spelling
            $table->json('line_fees')->nullable(); // detailed fee breakdown

            // Flexible metadata (JSON or serialized)
            $table->text('meta')->nullable();

            // Relationships
            $table->unsignedBigInteger('registered_by')->nullable();
            $table->unsignedBigInteger('hostel_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('term_id'); // intake/term reference
            $table->unsignedBigInteger('academic_year_id'); // academic year   reference
            $table->unsignedBigInteger('company_id'); // enforce multi-tenant scope

            $table->timestamps();
            $table->softDeletes();

            // Constraints
            $table->unique(['term_id', 'student_id'], 'unique_term_registration'); // student can only register once per term

            $table->unique(['company_id', 'term_id', 'student_id', 'semester', 'year'], 'unique_semester_registration');

            // Foreign keys
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('hostel_id')->references('id')->on('hostels')->onDelete('set null');
            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intake_registrations');
    }
}
