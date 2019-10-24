<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangesInColumnsInProductsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('products', function ($table) {
      $table->string('name', 255)->change();
      $table->decimal('sale_price',10,2)->nullable()->change();
      $table->decimal('price',10,2)->change();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('products', function ($table) {
      $table->string('name',191)->change();
      $table->decimal('sale_price',5,2)->nullable(false)->change();
      $table->decimal('price',5,2)->change();
    });
  }
}
