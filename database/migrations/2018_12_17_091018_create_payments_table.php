<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('MerchantTradeNo');
            $table->dateTime('MerchantTradeDate');
            $table->dateTime('PaymentDate')->nullable();
            $table->string('TradeDescription');
            $table->string('ItemName');
            $table->integer('UnitPrice');
            $table->integer('Quantity');
            $table->integer('Amount');
            $table->integer('Status')->default(0);
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
        Schema::dropIfExists('payments');
    }
}
