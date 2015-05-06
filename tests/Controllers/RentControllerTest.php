<?php

namespace Controllers ;

class RentControllerTest extends \TestCase
{
	public function testSimple()
	{
		$response = $this->call('GET', '/');
		//error_log( gettype($response));
		//error_log( get_class($response));

	}

	public function ZZZtestSave()
	{
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

		/*
		 * http://lumen.laravel.com/docs/testing#calling-routes-from-tests
		 * 
		$response = $this->call(
			$method, $uri, $parameters, $cookies, $files, $server, $content
		);
		*/

		$response = $this->call('POST', '/rent', $input );
		
		error_log( var_export($response,true));
		//$view = $response->getOriginalContent();
		$view = $response->original;
		//$view = $response->getContent();
		
		$this->assertEquals('Tours', $view['city']);

	}
}
