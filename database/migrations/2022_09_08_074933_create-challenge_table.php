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
        Schema::create('challenge', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name', 150);
            $table->text('description');
            $table->string('image', 255)->nullable();
            $table->enum('type', ['individual', 'group']);
            $table->enum('group_type', ['random', 'pick']);
            $table->integer('max_participant');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('day_start_time');
            $table->time('day_end_time');
            $table->json('elevation_point')->nullable();
            $table->json('distance_point')->nullable();
            $table->integer('time_point')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'ended']);
            $table->boolean('deleted');
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
        Schema::dropIfExists('challenge');
    }
};
