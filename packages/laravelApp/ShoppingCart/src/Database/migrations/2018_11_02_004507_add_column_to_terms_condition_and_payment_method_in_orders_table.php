<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToTermsConditionAndPaymentMethodInOrdersTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('orders', function (Blueprint $table) {
      $table->boolean('terms_conditions')->after('user_card_info_id');
      $table->string('payment_method')->default('CC')->after('terms_conditions')->nullable();
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
      $table->dropColumn('terms_conditions');
      $table->dropColumn('payment_method');
    });
  }
}
