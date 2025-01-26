<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticeBoardTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_board', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->nullable();
            $table->string('title');
            $table->text('message');
            $table->date('notice_date');
            $table->date('published_on')->nullable();
            $table->enum('published', ['0','1'])->default('0');
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->softDeletes();

        });
        Schema::create('notice_tos', function (Blueprint $table) {
            $table->id();
            $table->string('user_type');
            $table->unsignedBigInteger('notice_id')->nullable();
            $table->timestamps();
            $table->foreign('notice_id')->references('id')->on('notice_board')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notice_board_tables');
    }
}
