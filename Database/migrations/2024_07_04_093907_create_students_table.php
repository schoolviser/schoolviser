<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();
            $table->string('admission_number')->nullable();
            $table->text('photo')->nullable();
            $table->string('regno')->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('nationality')->nullable();
            $table->string('city')->nullable();
            $table->string('village')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('nin')->nullable();
            $table->string('lin')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('diseased', ['1', '0'])->default('0')->nullable();
            $table->date('diseased_on')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('school_pay_code')->unique()->nullable();
            $table->string('flux_code')->unique()->nullable();
            $table->string('access_number')->nullable();

            $table->longText('meta')->nullable();

            $table->enum('imported', ['0','1'])->default('0');

            $table->string('name')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('password')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();
            $table->date('archived_at')->nullable();
            $table->date('terminated_on')->nullable();
            $table->date('suspended_on')->nullable();

            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');


            $table->unsignedBigInteger('suspended_by')->nullable();
            $table->foreign('suspended_by')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('year_group_id')->nullable();
            $table->foreign('year_group_id')->references('id')->on('year_groups')->onDelete('set null');

            $table->unsignedBigInteger('course_group_id')->nullable();
            $table->foreign('course_group_id')->references('id')->on('course_groups')->onDelete('set null');


            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');

            // Composite unique constraints per company
            $table->unique(['company_id', 'nin']);
            $table->unique(['company_id', 'phone']);
            $table->unique(['company_id', 'email']);
            $table->unique(['company_id', 'regno']);
            $table->unique(['company_id', 'access_number']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
