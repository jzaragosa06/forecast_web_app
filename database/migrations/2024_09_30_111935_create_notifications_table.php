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
        Schema::create('notifications', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('file_assoc_id');
            $table->unsignedBigInteger('shared_by_user_id');
            $table->boolean('read')->default(false); // For tracking if the notification has been read
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('file_assoc_id')->references('file_assoc_id')->on('file_associations')->onDelete('cascade');
            $table->foreign('shared_by_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
