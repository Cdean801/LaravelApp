<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnShippingAddressIdToOrderTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('orders', function (Blueprint $table) {
      $table->integer('shipping_address_id')->unsigned()->nullable()->after('billing_address_id');
      $table->foreign('shipping_address_id')
      ->references('id')->on('billing_address');
      $table->string('card_holder_name')->nullable()->change();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('orders', function (Blueprint $table) {
      $table->dropForeign('orders_shipping_address_id_foreign');
      $table->dropColumn('shipping_address_id');
      $table->string('card_holder_name')->nullable(false)->change();
    });
  }
}
