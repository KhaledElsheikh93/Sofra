<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('description');
			$table->double('price');
			$table->double('offering_price');
			$table->integer('duration');
			$table->integer('restaurant_id')->unsigned();
			$table->string('image')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}