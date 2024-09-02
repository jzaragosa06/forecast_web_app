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
        Schema::create('file_associations', function (Blueprint $table) {
            $table->bigIncrements('file_assoc_id');
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('user_id');

            $table->string('associated_file_path');
            $table->string('operation');
            $table->timestamps();

            $table->foreign('file_id')->references('file_id')->on('files')->onDelete('cascade');
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
        Schema::dropIfExists('file_associations');
    }
};
