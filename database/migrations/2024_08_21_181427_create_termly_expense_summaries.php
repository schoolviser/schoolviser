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
        Schema::create('termly_expense_summaries', function (Blueprint $table) {

            $table->id();
            $table->string('amount');
            $table->string('month');
            

            $table->unsignedBigInteger('term_id')->nullable();
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('set null');

            $table->unique(['month', 'term_id'], '12hdd');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('termly_expense_summaries');
    }
};
