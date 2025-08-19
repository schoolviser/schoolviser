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
        Schema::table('terms', function (Blueprint $table) {
            if (!Schema::hasColumn('terms', 'uuid')) {
                $table->uuid('uuid')->unique()->after('id');
            }

            if (!Schema::hasColumn('terms', 'name')) {
                $table->string('name')->unique()->nullable();
            }

            if (!Schema::hasColumn('terms', 'registration_deadline')) {
                $table->date('registration_deadline')->nullable()->after('end_date');
            }

            if (!Schema::hasColumn('terms', 'exam_start_date')) {
                $table->date('exam_start_date')->nullable()->after('registration_deadline');
            }

            if (!Schema::hasColumn('terms', 'exam_end_date')) {
                $table->date('exam_end_date')->nullable()->after('exam_start_date');
            }

            if (!Schema::hasColumn('terms', 'results_release_date')) {
                $table->date('results_release_date')->nullable()->after('exam_end_date');
            }

            if (!Schema::hasColumn('terms', 'status')) {
                $table->string('status')->default('active')->after('academic_year_id');
            }

            if (!Schema::hasColumn('terms', 'is_current')) {
                $table->boolean('is_current')->default(false)->after('status');
            }

            if (!Schema::hasColumn('terms', 'week_count')) {
                $table->integer('week_count')->nullable()->after('is_current');
            }

            if (!Schema::hasColumn('terms', 'credit_limit')) {
                $table->integer('credit_limit')->nullable()->after('week_count');
            }

            if (!Schema::hasColumn('terms', 'deleted_at')) {
                $table->softDeletes(); // adds deleted_at
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('terms', function (Blueprint $table) {
            if (Schema::hasColumn('terms', 'uuid')) {
                $table->dropColumn('uuid');
            }
            if (Schema::hasColumn('terms', 'registration_deadline')) {
                $table->dropColumn('registration_deadline');
            }
            if (Schema::hasColumn('terms', 'exam_start_date')) {
                $table->dropColumn('exam_start_date');
            }
            if (Schema::hasColumn('terms', 'exam_end_date')) {
                $table->dropColumn('exam_end_date');
            }
            if (Schema::hasColumn('terms', 'results_release_date')) {
                $table->dropColumn('results_release_date');
            }
            if (Schema::hasColumn('terms', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('terms', 'is_current')) {
                $table->dropColumn('is_current');
            }
            if (Schema::hasColumn('terms', 'week_count')) {
                $table->dropColumn('week_count');
            }
            if (Schema::hasColumn('terms', 'credit_limit')) {
                $table->dropColumn('credit_limit');
            }
            if (Schema::hasColumn('terms', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
