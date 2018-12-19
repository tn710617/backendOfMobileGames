<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscapeRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escape_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('FindLittleMan')->default(0);
            $table->integer('YouAreSoFast')->default(0);
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
        Schema::dropIfExists('escape_rooms');
    }
}
