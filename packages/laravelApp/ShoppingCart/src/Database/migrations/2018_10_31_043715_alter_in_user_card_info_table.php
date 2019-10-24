<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInUserCardInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_card_info', function (Blueprint $table) {
          $table->string('trans_id')->nullable()->change();
          $table->boolean('is_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_card_info', function (Blueprint $table) {
          $table->string('trans_id')->nullable(false)->change();
          $table->dropColumn('is_primary');
        });
    }
}
