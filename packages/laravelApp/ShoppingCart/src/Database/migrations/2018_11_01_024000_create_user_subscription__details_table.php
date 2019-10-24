<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSubscriptionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscription_details', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
         // $table->foreign('user_id')->references('id')->on('users');
          $table->integer('user_card_info_id')->unsigned();
         // $table->foreign('user_card_info_id')->references('id')->on('user_card_info');
          $table->date('start_date');
          $table->date('end_date');
          $table->decimal('amount', 8, 2);
          $table->string('status');
          $table->string('message')->nullable();
          $table->string('invoice_number')->nullable();
          $table->string('auth_number')->nullable();
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
        Schema::dropIfExists('user_subscription_details');
    }
}
