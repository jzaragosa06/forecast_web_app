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
       
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_photo')->nullable();
            $table->string('contact_num')->nullable();
            $table->string('location')->nullable();  // Added field
            $table->string('headline')->nullable();  // Added field
            $table->text('about')->nullable();       // Added field for user bio/about
            $table->text('skills')->nullable();      // Added field for skills as JSON or comma-separated
            $table->string('social_links_linkedin')->nullable();
            $table->string('social_links_github')->nullable();
            $table->string('social_links_kaggle')->nullable();
            $table->string('social_links_medium')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};