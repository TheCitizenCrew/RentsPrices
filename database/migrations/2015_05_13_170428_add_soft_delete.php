<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDelete extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	
		Schema::table('rent_prices', function(Blueprint $table)
		{
			$table->softDeletes();
		});

		Schema::table('rents', function(Blueprint $table)
		{
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
		Schema::table('rent_prices', function(Blueprint $table)
		{
			//
		});
		Schema::table('rents', function(Blueprint $table)
		{
		});

	}

}
