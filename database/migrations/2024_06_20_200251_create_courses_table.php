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
            $table->string('name')->unique();
            $table->string('abbr')->unique()->nullable();
            $table->text('description')->nullable();
            $table->integer('duration')->nullable();
            $table->text('meta')->nullable();
            $table->string('award')->unique()->nullable();

            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');

            $table->timestamps();
        });
        Schema::create('course_units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique()->nullable();
            $table->enum('year', ['1','2','3','4'])->default('1');
            $table->enum('semester', ['1','2','3'])->default('1');
            $table->text('description')->nullable();
            $table->text('meta')->nullable();

            // Foreign key constraint
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

            $table->timestamps();
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
        //Schema::dropIfExists('courses');

    }
}
