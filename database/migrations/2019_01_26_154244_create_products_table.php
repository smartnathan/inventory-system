<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->string('name');
            $table->integer('brand_id');
            $table->integer('created_by');
            $table->integer('category_id');
            $table->string('code');
            $table->string('image')->nullable();
            $table->decimal('cost_price');
            $table->integer('unit_of_measurement_id');
            $table->text('description')->nullable();
            $table->boolean('is_active')->nullable();
            $table->integer('wholesale_min_quantity');
            $table->decimal('retail_price');
            $table->decimal('whole_sale_price');
            $table->text('remark')->nullable();
            $table->timestamps();
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
        Schema::drop('products');
    }
}
