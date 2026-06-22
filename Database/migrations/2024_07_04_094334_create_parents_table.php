<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid()->unique()->nullable();
            $table->string('surname');
            $table->string('other_names');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('ocupation')->nullable();
            $table->string('nin')->nullable();
            $table->string('phone_one')->nullable();
            $table->string('phone_two')->nullable();
            $table->string('email')->nullable();
            $table->string('nationality')->nullable();
            $table->string('city')->nullable();
            $table->string('village')->nullable();
            $table->string('relationship')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->date('archived_at')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('student_perent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('perent_id');
            $table->unsignedBigInteger('student_id');
            $table->string('type')->nullable();
            $table->foreign('perent_id')->references('id')->on('perents')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
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
        Schema::dropIfExists('student_perent');
    }
}
