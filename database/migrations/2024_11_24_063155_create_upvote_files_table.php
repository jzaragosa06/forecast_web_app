<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upvote_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('public_file_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('public_file_id')->references('id')->on('public_files')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upvote_files');
    }
};