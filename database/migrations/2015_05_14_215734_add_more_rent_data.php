<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreRentData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rents', function(Blueprint $table)
		{
			$table->boolean('buildingHLM')->nullable()->after('buildingIndividual');
			$table->double('surfaceM2')->default(0.0)->after('buildingHLM');
			$table->integer('roomsCount')->default(0)->after('surfaceM2');
			$table->boolean('kitchenRoom')->nullable()->after('roomsCount');
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
			$table->removeColumn('buildingHLM');
			$table->removeColumn('roomsCount');
			$table->removeColumn('surfaceM2');
			$table->removeColumn('kitchenRoom');
		});
	}

}
