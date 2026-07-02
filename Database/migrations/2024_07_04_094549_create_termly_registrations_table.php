<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermlyRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termly_registrations', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            // Boarding vs day students
            $table->enum('residence', ['boarding','day'])->default('boarding');

            // Whether student is new or continuing
            $table->enum('new_or_continuing', ['new','continuing'])->default('new');

            // Registration date
            $table->date('registered_on')->nullable();

            // Flexible metadata (JSON or serialized)
            $table->text('meta')->nullable();

            $table->boolean('locked')->default(false); // lock registration to prevent changes
            
            // Financial fields
            $table->string('balance_carried_forward')->nullable(); // corrected spelling
            $table->json('line_fees')->nullable(); // detailed breakdown of fees
            $table->boolean('excluded_from_fees')->default(false); // clearer than enum

            // Relationships
            $table->unsignedBigInteger('registered_by')->nullable();
            $table->unsignedBigInteger('clazz_id');
            $table->unsignedBigInteger('stream_id');
            $table->unsignedBigInteger('hostel_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('term_id');
            $table->unsignedBigInteger('company_id'); // enforce multi-tenant scope

            $table->timestamps();
            $table->softDeletes();

            // Constraints
            $table->unique(['company_id', 'term_id', 'student_id'], 'unique_termly_registration');

            // Foreign keys
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('clazz_id')->references('id')->on('clazzs');
            $table->foreign('stream_id')->references('id')->on('streams');
            $table->foreign('hostel_id')->references('id')->on('hostels')->onDelete('set null');
            $table->foreign('term_id')->references('id')->on('terms');
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
        Schema::dropIfExists('termly_registrations');
    }
}
