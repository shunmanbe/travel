<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            // これを選択してデータを取ってくる。データを取ってくるときの指標。(主キーでないものはindexをつける)
            // $table->primary('user_id');
            $table->timestamps();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            
            $table->foreign('user_id') //外部キー制約
                ->references('id') //参照カラム
                ->on('users'); //参照テーブル
            
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_user');
    }
}
