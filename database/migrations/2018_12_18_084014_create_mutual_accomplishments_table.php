<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMutualAccomplishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutual_accomplishments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->boolean('FindLittleMan')->default(0);
            $table->boolean('YouAreFilthyRich')->default(0);
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
        Schema::dropIfExists('mutual_accomplishments');
    }
}
