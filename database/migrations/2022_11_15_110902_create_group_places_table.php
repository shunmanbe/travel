<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('share_itinerary_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->datetime('departure_time')->nullable();
            $table->boolean('departure_time_flag')->nullable();
            $table->datetime('arrival_time')->nullable();
            $table->boolean('arrival_time_flag')->nullable();
            $table->string('memo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_places');
    }
}
