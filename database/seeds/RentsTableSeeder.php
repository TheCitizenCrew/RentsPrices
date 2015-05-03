<?php

use Illuminate\Database\Seeder;

class RentsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('rent_prices')->delete();
		DB::table('rents')->delete();

		$rt = \App\Models\Rent::create([
				'buildingIndividual' => 0,
				'buildingStage' => 2,
				'buildingName' => '',
				'street' => '29 quai Paul Bert',
				'zipcode' => '37100',
				'city' => 'Tours',
		]);

		$rp = \App\Models\RentPrice::create([
				'year' => '2014',
				'price'=>500,
				'rent_id'=>$rt->id
		]);
		$rp = \App\Models\RentPrice::create([
				'year' => '2015',
				'price'=>500,
				'rent_id'=>$rt->id
		]);

	}

}
