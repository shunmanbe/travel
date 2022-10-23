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
            $table->string('title', 50);
            $table->unsignedBigInteger('user_id'); //外部キー
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id') //外部キー制約, 参照先テーブル（親テーブル）にないuserのidはitinerariesテーブルに登録させない
                    ->references('id') //参照元のカラム名
                    ->on('users') //参照先テーブル名
                    ->onDelete('cascade'); //参照先テーブル・参照先レコードを削除しようとした時、子テーブルの参照データも削除される
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itineraries'); //itinerariesテーブルが存在していれば削除する
    }
}
