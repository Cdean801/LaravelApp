<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false);
            $table->text('description');
            $table->string('sku')->nullable(false);
            $table->boolean('active')->nullable(false);
            $table->decimal('sale_price', 5, 2)->nullable(false);
            $table->decimal('regular_price', 5, 2);
            $table->integer('in_stock_quantity')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
