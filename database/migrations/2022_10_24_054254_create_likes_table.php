<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->unsignedBigInteger('user_id'); //usersテーブルの外部キー設定
            $table->foreign('user_id') //外部キー制約
                ->references('id') //参照カラム
                ->on('users') //参照テーブル
                ->onDelete('cascade'); //userが削除されたときに、userに紐づくlikeも一緒に削除   
                
            $table->unsignedBigInteger('itinerary_id'); //上記と同様
            $table->foreign('itinerary_id')
                ->references('id')
                ->on('itineraries')
                ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
