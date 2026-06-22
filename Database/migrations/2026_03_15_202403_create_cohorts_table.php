<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void
    {
        Schema::create('cohorts', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();
            $table->string('name'); // e.g. "Set A", "Class of 2026"
            $table->string('short_code', 10)->nullable();
            $table->text('description')->nullable();

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');

            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');

            $table->boolean('active')->default(true);
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();

            $table->timestamps();

            $table->unique(['name', 'company_id'], 'uniq_cohort_name');
            $table->unique(['short_code', 'company_id'], 'uniq_cohort_code');
        });

        // Pivot table to track student assignments over time
        Schema::create('cohort_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cohort_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('academic_year_id')->nullable();

            $table->date('assigned_on')->nullable();
            $table->date('removed_on')->nullable();
            $table->string('reason')->nullable(); // e.g. "moved", "gap year"

            $table->timestamps();

            $table->foreign('cohort_id')->references('id')->on('cohorts')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cohort_student');
        Schema::dropIfExists('cohorts');
    }
};