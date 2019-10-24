<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableTimeSlots extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('time_slots', function (Blueprint $table) {
      $table->dropColumn('start');
      $table->dropColumn('end');
      $table->date('slot_date');
      $table->string('slot');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('time_slots', function (Blueprint $table) {
      $table->dateTime('start');
      $table->dateTime('end');
      $table->dropColumn('slot_date');
      $table->dropColumn('slot');
    });
  }
}
