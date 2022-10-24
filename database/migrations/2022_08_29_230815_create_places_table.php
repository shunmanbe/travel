<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('itinerary_id')->unsigned()->nullable();
            $table->string('destination_address')->nullable();
            $table->string('destination_name')->nullable();
            $table->datetime('departure_time')->nullable();
            $table->datetime('arrival_time')->nullable();
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
        Schema::dropIfExists('places');
    }
}
