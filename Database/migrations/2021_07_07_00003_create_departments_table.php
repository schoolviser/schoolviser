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
        if (!Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->id();

                // Tenant awareness: link to companies table
                $table->unsignedBigInteger('company_id');
                $table->foreign('company_id')
                      ->references('id')
                      ->on('companies')
                      ->onDelete('cascade');
                
                $table->unique(['name', 'company_id'], 'uniq_company_depart');

                // Department-specific fields
                $table->string('name');
                $table->string('code')->nullable(); // optional short code for department
                $table->text('description')->nullable();

                $table->timestamps();
                $table->softDeletes(); // optional, for safe deletion
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};