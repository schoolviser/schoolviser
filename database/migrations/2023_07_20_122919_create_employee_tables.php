<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('level_of_education', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('work_number')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->date('date_of_birth')->nullable();
            $table->enum('marital_status', ['divorced', 'married', 'single'])->default('single');
            $table->string('initials')->nullable();
            $table->string('nationality')->nullable();
            $table->string('home_address')->nullable();
            $table->string('current_address')->nullable();

            $table->string('email')->nullable()->unique();
            $table->string('primary_phone')->nullable();
            $table->string('other_phone')->nullable();

            $table->string('nin')->nullable()->uniue();
            $table->string('religion')->nullable();
            $table->string('contract_type')->nullable();
            $table->enum('teacher', ['1', '0'])->default('0')->nullable();
            $table->enum('diseased', ['1', '0'])->default('0')->nullable();
            $table->enum('confirmed', ['1', '0'])->default('0')->nullable();
            $table->date('hire_date')->nullable();
            $table->date('archived_at')->nullable();
            $table->date('left_on')->nullable();
            $table->date('terminated_on')->nullable();
            $table->unsignedBigInteger('employee_position_id')->nullable();
            $table->unsignedBigInteger('level_of_education_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('employee_position_id')->references('id')->on('employee_positions')->onDelete('set null');
            $table->foreign('level_of_education_id')->references('id')->on('level_of_education')->onDelete('set null');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('employee_department', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();

            $table->primary(['department_id', 'employee_id'], 'department_employee');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('previous_work_places', function (Blueprint $table) {
            $table->id();
            $table->string('employer');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::create('employee_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->text('file');
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('employee_emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('employee_position_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('employee_positions')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->date('leave_date');
            $table->date('adjusted_date')->nullable();
            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('set null');
        });

    

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_positions');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_departments');
        Schema::dropIfExists('level_of_education');
        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('leave_requests');
    }
}
