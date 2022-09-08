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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_token', 255)->nullable();
            $table->dateTime('verification_token_expired')->nullable();
            $table->string('forgot_token', 255)->nullable();
            $table->dateTime('forgot_token_expired')->nullable();
            $table->string('password');
            $table->string('avatar', 255)->nullable();
            $table->enum('status', ['pending', 'active', 'blocked']);
            $table->string('method')->nullable();
            $table->string('firebase_uid')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->string('strava_id')->nullable();
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
