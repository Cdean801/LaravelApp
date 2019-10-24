<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInProductsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('products', function (Blueprint $table) {
      $table->string('image',255)->nullable();
      $table->renameColumn('regular_price', 'price');
      $table->string('url',255)->nullable();
      $table->boolean('stock_status');
      $table->decimal('shipping_weight',10, 2);
      $table->decimal('shipping_length', 10, 2);
      $table->decimal('shipping_width', 10, 2);
      $table->decimal('shipping_height', 10, 2);
      $table->integer('category_id')->unsigned();
      $table->foreign('category_id')->references('id')->on('categories');
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
      $table->dropColumn('image');
      $table->renameColumn('price', 'regular_price');
      $table->dropColumn('url');
      $table->dropColumn('stock_status');
      $table->dropColumn('shipping_weight');
      $table->dropColumn('shipping_length');
      $table->dropColumn('shipping_width');
      $table->dropColumn('shipping_height');
    $table->dropForeign('products_category_id_foreign');
    // $table->dropForeign('table_category_id_foreign');
      $table->dropColumn('category_id');
    });
  }
}
