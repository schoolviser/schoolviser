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
            $table->year('year');
            $table->enum('term', ['1','2','3','4'])->default('1');
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('meta')->nullable();
            $table->date('next_term_start_date')->nullable();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->timestamps();

            $table->unique(['year', 'term'], 'unique_term');
            $table->unique(['academic_year_id', 'term'], 'unique_term_year');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');

            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');
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
