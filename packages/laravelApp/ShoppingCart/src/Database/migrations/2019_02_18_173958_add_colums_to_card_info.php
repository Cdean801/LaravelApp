<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToCardInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('user_card_info', function (Blueprint $table) {
            $table->string('expiration')->nullable();
            $table->datetime('token')->nullable();
            $table->datetime('csv')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        $table->dropColumn('expiration');
        $table->dropColumn('token');
        $table->dropColumn('csv');
    }
}
