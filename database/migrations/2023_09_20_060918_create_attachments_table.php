<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('url');
            $table->string('extension')->nullable();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->timestamps();
            $table->index(['model_type', 'model_id','url'], 'model_has_unique_attachments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
