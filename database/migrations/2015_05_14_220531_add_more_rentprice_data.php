<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreRentpriceData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rent_prices', function(Blueprint $table)
		{
			$table->integer('month')->after('year')->default(0);
			$table->double('loads')->after('price')->default(0.0);
			$table->double('loadsOther')->default(0.0)->after('loads');
			$table->string('loadsOtherText')->nullable()->after('loadsOther');
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
			$table->removeColumn('month');
			$table->removeColumn('loads');
			$table->removeColumn('loadsOther');
			$table->removeColumn('loadsOtherText');
		});
	}

}
