<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            // $table->foreign('user_id')
            //   ->references('id')->on('users')
            //   ->onDelete('cascade');
            $table->integer('time_slot_id')->unsigned()->nullable();
            // $table->foreign('time_slot_id')
            //   ->references('id')->on('time_slots')
            //   ->onDelete('cascade');
            $table->boolean('paid');
            $table->string('payment_reference');
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
        Schema::dropIfExists('orders');
    }
}
