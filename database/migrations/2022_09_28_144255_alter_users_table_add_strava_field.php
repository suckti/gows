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
        Schema::table('user', function (Blueprint $table) {
            $table->unsignedBigInteger('strava_athlete_id')->nullable();
            $table->string('strava_token', 255)->nullable();
            $table->string('strava_refresh_token', 255)->nullable();
            $table->integer('strava_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('strava_athlete_id');
            $table->dropColumn('strava_token');
            $table->dropColumn('strava_refresh_token');
            $table->dropColumn('strava_expires_at');
        });
    }
};
