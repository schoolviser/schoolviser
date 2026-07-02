<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_papers', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();

            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('company_id'); // tenant scope

            $table->string('name'); // Full paper name
            $table->string('short_name')->nullable(); // e.g. "Eng P1"
            $table->string('code')->nullable(); // e.g. "112/1"
            $table->boolean('compulsory')->default(false);
            $table->integer('weight')->nullable(); // optional weighting/marks
            $table->text('meta')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Constraints
            $table->unique(['company_id', 'subject_id', 'code'], 'uniq_subject_paper_code');

            // Audit trail
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_papers');
    }
};
