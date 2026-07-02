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
        Schema::create('student_course_group_histories', function (Blueprint $table) {
            $table->id();

            // 🔗 Student reference
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            // 🔗 Old and new course groups
            $table->foreignId('old_course_group_id')->nullable()->constrained('course_groups')->nullOnDelete();
            $table->foreignId('new_course_group_id')->nullable()->constrained('course_groups')->nullOnDelete();

            // 📚 Reason for change
            $table->enum('reason', ['dead_year', 'course_change', 'transfer','initial_assignment'])->nullable();
            $table->text('remarks')->nullable();

            // 📝 Audit trail
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('changed_on')->useCurrent();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_course_group_histories');
    }
};
