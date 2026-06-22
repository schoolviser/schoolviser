<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermlyRegistrationSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('termly_registration_summaries', function (Blueprint $table) {
            $table->id();

            // Cached totals for quick reporting
            $table->unsignedInteger('number_of_students')->default(0);
            $table->unsignedInteger('male')->default(0);
            $table->unsignedInteger('female')->default(0);

            // Optional breakdowns
            $table->unsignedInteger('boarding')->default(0);
            $table->unsignedInteger('day')->default(0);
            $table->unsignedInteger('new_students')->default(0);
            $table->unsignedInteger('continuing_students')->default(0);

            // Scope
            $table->unsignedBigInteger('term_id');
            $table->unsignedBigInteger('company_id');

            $table->timestamps();

            // Constraints
            $table->unique(['company_id', 'term_id'], 'unique_term_summary');

            // Foreign keys
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
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
        Schema::dropIfExists('termly_registration_summaries');
    }
}
