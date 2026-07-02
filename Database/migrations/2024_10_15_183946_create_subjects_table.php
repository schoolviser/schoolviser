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
       Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('short_code')->nullable();
            $table->enum('level', ['o','a'])->default('o');
            $table->boolean('compulsory')->default(false);
            $table->text('meta')->nullable();

            $table->unsignedBigInteger('company_id');

            $table->timestamps();

            // Constraints
            $table->unique(['company_id', 'name', 'level'], 'unique_subject_level');
            $table->unique(['company_id', 'short_code', 'level'], 'unique_subject_level_code');

            // Foreign keys
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
