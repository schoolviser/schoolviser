<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('student_statistics', function (Blueprint $table) {
    $table->bigIncrements('id');

    // Cached totals for quick reporting
    $table->unsignedInteger('total_students')->default(0);
    $table->unsignedInteger('total_male_students')->default(0);
    $table->unsignedInteger('total_female_students')->default(0);

    // Status breakdowns
    $table->unsignedInteger('total_active_students')->default(0);
    $table->unsignedInteger('total_graduated_students')->default(0);
    $table->unsignedInteger('total_suspended_students')->default(0);
    $table->unsignedInteger('total_terminated_students')->default(0);
    $table->unsignedInteger('total_archived_students')->default(0);

    // Optional breakdowns for richer dashboards
    $table->unsignedInteger('total_boarding_students')->default(0);
    $table->unsignedInteger('total_day_students')->default(0);
    $table->unsignedInteger('total_new_students')->default(0);
    $table->unsignedInteger('total_continuing_students')->default(0);

    // Metadata
    $table->timestamp('last_updated_at')->nullable();
    $table->timestamps();

    // Scope
    $table->unsignedBigInteger('term_id')->nullable();
    $table->unsignedBigInteger('company_id');

    // Constraints
    $table->unique(['company_id', 'term_id'], 'unique_term_statistics');

    // Foreign keys
    $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
    $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_statistics');
    }
};
