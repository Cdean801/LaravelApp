<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSizeToProducts extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('products', function (Blueprint $table) {
      $table->decimal('size', 5, 2);
      $table->string('size_unit');
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
      $table->dropColumn('size');
      $table->dropColumn('size_unit');
    });
  }
}
