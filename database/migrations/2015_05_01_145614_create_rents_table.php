<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('buildingIndividual')->nullable();
			$table->integer('buildingStage');
			$table->string('buildingName');
			$table->string('street');
			$table->string('zipcode');
			$table->string('city');
			$table->timestamps(); // Adds created_at and updated_at columns
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rents');
	}

}
