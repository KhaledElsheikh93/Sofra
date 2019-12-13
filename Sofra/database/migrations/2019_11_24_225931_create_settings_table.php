<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('about_app');
			$table->double('commission');
			$table->string('text1');
			$table->string('text2');
			$table->double('max_credit');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}