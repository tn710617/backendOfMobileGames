<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGifStopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gif_stops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('FindLittleMan')->default(0);
            $table->integer('APerfectScore')->default(0);
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
        Schema::dropIfExists('gif_stops');
    }
}
