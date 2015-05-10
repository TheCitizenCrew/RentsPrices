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
			'country' => 'France',
			'addrLat' => 47.4019148782551,
			'addrLng' => 0.68988561630249
		]);

		$rp = \App\Models\RentPrice::create([
			'year' => '2014', 'price'=>500, 'rent_id'=>$rt->id
		]);
		$rp = \App\Models\RentPrice::create([
			'year' => '2015', 'price'=>500, 'rent_id'=>$rt->id
		]);

		$rt = \App\Models\Rent::create([
			'buildingIndividual' => 0,
			'buildingStage' => 4,
			'buildingName' => '',
			'street' => '74 Rue Philippe de Girard',
			'zipcode' => '75018',
			'city' => 'Tours',
			'country' => 'France',
			'addrLat' => 48.8883675,
			'addrLng' => 2.360674
		]);

	}

}
