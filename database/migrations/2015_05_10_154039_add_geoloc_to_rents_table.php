<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeolocToRentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rents', function(Blueprint $table)
		{
			$table->double('addrlat')->nullable();
			$table->double('addrlng')->nullable();
			$table->string('country')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('rents', function(Blueprint $table)
		{
			//
		});
	}

}
