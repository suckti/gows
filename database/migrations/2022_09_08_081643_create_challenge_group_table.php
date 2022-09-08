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
        Schema::create('challenge_group', function (Blueprint $table) {
            $table->id();
            $table->integer('challenge_id');
            $table->string('name', 150);
            $table->integer('total_elevation_point')->nullable()->default(0);
            $table->integer('total_distance_point')->nullable()->default(0);
            $table->integer('total_time_point')->nullable()->default(0);
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
        Schema::dropIfExists('challenge_group');
    }
};
