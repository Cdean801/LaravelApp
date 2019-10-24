<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsProductImages extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('product_images', function (Blueprint $table) {
      $table->integer('product_id')->unsigned();
      $table->dropColumn(['name']);
      $table->boolean('featured')->nullable();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('product_images', function (Blueprint $table) {
      $table->dropColumn(['product_id']);
      $table->string('name');
      $table->dropColumn(['featured']);
    });
  }
}
