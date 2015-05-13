<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RentsAddManualGeoloc extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rents', function(Blueprint $table)
		{
			$table->boolean('geoloc_manual')->default(false);

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
			$table->removeColumn('geoloc_manual');
		});
	}

}
