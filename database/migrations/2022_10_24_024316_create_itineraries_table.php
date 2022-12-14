<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItinerariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itineraries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->string('explanation')->nullable();
            $table->date('departure_date');
            $table->date('arrival_date');
            $table->string('departure_place_name')->nullable();
            $table->string('departure_place_address')->nullable();
            $table->string('departure_place_lat')->nullable();
            $table->string('departure_place_lng')->nullable();
            $table->string('memo')->nullable();
            $table->integer('likes_count')->default(0);
            // 画像のパスを保存するカラムを追加
            $table->string('image_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itineraries');
    }
}

