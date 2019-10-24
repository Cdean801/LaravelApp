<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAddressTypeAndIsPrimaryToBillingAddressTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('billing_address', function (Blueprint $table) {
      $table->string('address_title',255)->after('user_id');
      $table->boolean('is_primary')->after('email');
      $table->string('state')->nullable()->change();
      $table->softDeletes();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('billing_address', function (Blueprint $table) {
      $table->dropColumn('address_title');
      $table->dropColumn('is_primary');
      $table->string('state')->nullable(false)->change();
      $table->dropSoftDeletes();
    });
  }
}
