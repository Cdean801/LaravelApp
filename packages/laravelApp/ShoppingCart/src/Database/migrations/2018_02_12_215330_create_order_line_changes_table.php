<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLineChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_line_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_line_id')->unsigned();
            $table->foreign('order_line_id')
              ->references('id')->on('order_lines')
              ->onDelete('cascade');
            $table->integer('reason');
            $table->integer('initial_quantity');
            $table->integer('final_quantity');
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
        Schema::dropIfExists('order_line_changes');
    }
}
