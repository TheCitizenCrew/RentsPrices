<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 *
 * Http Method Spoofing :
 * <form action="/foo/bar" method="POST">
 * <input type="hidden" name="_method" value="PUT">
 * <input type="hidden" name="_token" value="{{ csrf_token() }}">
 * </form>
 */
$app->get( '/', 'App\Http\Controllers\Controller@home' );

$app->group( [ 'prefix' => 'rent' ], 
	function ( $app )
	{
		$app->get( '', 'App\Http\Controllers\RentController@editNew' );
		$app->get( '/{id:[0-9]+}', 'App\Http\Controllers\RentController@edit' );
		$app->post( '', 'App\Http\Controllers\RentController@save' );
		$app->post( '/{id:[0-9]+}', 'App\Http\Controllers\RentController@update' );
	} );

/**
 * REST API
 * http://en.wikipedia.org/wiki/Representational_state_transfer
 * http://rest.elkstein.org/
 */
$app->group( [ 'prefix' => 'api' ], 
	function ( $app )
	{
		/**
		 * URIs for Rents
		 */
		$app->group( [ 'prefix' => 'rents' ], 
			function ( $app )
			{
				$app->get( '', 'App\Http\Controllers\Api\RentsController@find' );
				$app->post( '', 'App\Http\Controllers\Api\RentsController@create' );
				$app->get( '{id:[0-9]+}', 'App\Http\Controllers\Api\RentsController@get' );
				$app->put( '{id:[0-9]+}', 'App\Http\Controllers\Api\RentsController@save' );
				$app->delete( '{id:[0-9]+}', 'App\Http\Controllers\Api\RentsController@delete' );
			} );
	} );
