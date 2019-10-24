<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingAddressTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('billing_address', function (Blueprint $table) {
      $table->increments('id');
      $table->string('first_name', 255);
      $table->string('last_name', 255);
      $table->string('country', 255);
      $table->string('address1', 255);
      $table->string('address2', 255)->nullable();
      $table->string('town_city', 255);
      $table->string('state', 255);
      $table->string('zip', 11);
      $table->string('phone', 20);
      $table->string('email',191);
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
    Schema::dropIfExists('billing_address');
  }
}
