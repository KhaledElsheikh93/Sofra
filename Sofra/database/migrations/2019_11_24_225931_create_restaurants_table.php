<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->integer('district_id')->unsigned();
			$table->double('delivery_charge');
			$table->double('minimum_order');
			$table->string('contact_phone');
			$table->string('whats');
			$table->integer('category_id')->unsigned();
			$table->string('image')->nullable();
			$table->boolean('state')->default(1);
			$table->string('api_token')->nullable()->unique();
			$table->string('pin_code')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}