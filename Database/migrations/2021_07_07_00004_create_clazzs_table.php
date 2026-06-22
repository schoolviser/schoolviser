<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clazzs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid()->nullable()->unique();
            $table->string('name');
            $table->string('abbr')->nullable();
            $table->enum('level', ['ordinary', 'advanced'])->default('ordinary');
            $table->string('duration')->nullable();
            $table->string('code')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unique(['name', 'company_id'], 'uniq_clazz_name');
            $table->unique(['code', 'company_id'], 'uniq_clazz_code');


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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clazzs');
    }
};
