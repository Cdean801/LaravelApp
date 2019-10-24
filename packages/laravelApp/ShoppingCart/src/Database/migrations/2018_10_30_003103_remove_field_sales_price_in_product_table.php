<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldSalesPriceInProductTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('products', function (Blueprint $table) {
      $table->dropColumn('sale_price');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('products', function (Blueprint $table) {
      $table->decimal('sale_price', 5, 2)->nullable()->after('price');
    });
  }
}
