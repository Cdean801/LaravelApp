<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCardInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_card_info', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          //$table->foreign('user_id')->references('id')->on('users');
          $table->string('card_holder_name');
          $table->string('last4');
          $table->string('brand');
          $table->string('trans_id');
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
        Schema::dropIfExists('user_card_info');
    }
}
