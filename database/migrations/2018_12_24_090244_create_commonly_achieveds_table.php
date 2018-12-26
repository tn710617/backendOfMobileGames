<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonlyAchievedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commonly_achieveds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('common_achievement_id');
            $table->integer('mutual_achievement_id')->nullable()->default(null);
            $table->integer('number')->default(0);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('commonly_achieveds');
    }
}
