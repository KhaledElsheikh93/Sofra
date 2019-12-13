<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->integer('amount')->default('1');
			$table->string('special_order')->nullable();
			$table->text('notes')->nullable();
			$table->enum('payment_method', array('cash', 'online'));
			$table->double('total');
			$table->double('commission');
			$table->enum('state', array('pending', 'accepted', 'rejected', 'delivered', 'deleted'));
			$table->double('cost');
			$table->double('net');
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}