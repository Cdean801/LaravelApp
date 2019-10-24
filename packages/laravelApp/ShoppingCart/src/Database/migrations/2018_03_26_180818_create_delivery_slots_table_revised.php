<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverySlotsTableRevised extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('delivery_slots');
        Schema::create('delivery_slots', function (Blueprint $table) {
          $table->increments('id');
          $table->date('slot_date');
          $table->string('slot');
          $table->integer('max_per_slot');
          $table->boolean('active');
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
        Schema::dropIfExists('delivery_slots');
    }
}
