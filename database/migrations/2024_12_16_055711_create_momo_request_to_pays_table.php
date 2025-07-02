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
        Schema::create('momo_request_to_pays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id')->unique();
            $table->string('payer_id', 15);
            $table->decimal('amount', 15, 2);
            $table->string('momo_transaction_id')->nullable();
            $table->string('payer_message')->nullable();
            $table->string('payee_note')->nullable();
            $table->string('currency', 3)->default('UGX');
            $table->enum('status', ['pending', 'successful', 'failed'])->default('pending');
            $table->enum('transaction_status', ['pending', 'successful', 'failed'])->default('pending');
            $table->json('response_details')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->json('callback_data')->nullable(); //data to be used by the callback functions onSuccess and onFail
            $table->text('callback')->nullable(); //callback class
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('model_type')->nullable();
            $table->timestamps();

            $table->unique(['model_id', 'model_type']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('momo_request_to_pays');
    }
};
