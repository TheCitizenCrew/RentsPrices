<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentpricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rent_prices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('year');
			$table->double('price');
			$table->integer('rent_id')->unsigned();
			$table->foreign('rent_id')
				->references('id')->on('rents')
				->onDelete('cascade');
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
		Schema::drop('rent_prices');
	}

}
