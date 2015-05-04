<?php

namespace Essais;

class OrmUpdateOneToManyTest extends \TestCase
{

	/**
	 * @return void
	 */
	public function test01()
	{
		echo __METHOD__, "\n";

		$input = array(
			'buildingIndividual'=>1,
			'buildingStage'=> '2',
			'buildingName'=>'',
			'street'=>'29 quai Paul Bert',
			'zipcode'=>'37100', 'city'=>'Tours',
			'prices'=>array(
				array('year'=>2014, 'price'=>20),
				array('year'=>2015, 'price'=>30),
			)
		);

		$rent = new \App\Models\Rent( $input );
		$rent->push();

	}

	public function test02()
	{
		echo __METHOD__, "\n";
	}

}
