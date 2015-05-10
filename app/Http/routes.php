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
$app->get( '/about', 'App\Http\Controllers\Controller@about' );

$app->group( [ 'prefix' => 'rent' ], 
	function ( $app )
	{
		$app->get( '', 'App\Http\Controllers\RentController@editNew' );
		$app->get( '{id:[0-9]+}', 'App\Http\Controllers\RentController@show' );
		$app->get( '{id:[0-9]+}/edit', 'App\Http\Controllers\RentController@edit' );
		$app->post( '', 'App\Http\Controllers\RentController@save' );
		$app->post( '{id:[0-9]+}', 'App\Http\Controllers\RentController@update' );

	} );

$app->group( [ 'prefix' => 'api' ],
	function ( $app )
	{
		$app->get( 'rentsCount', 'App\Http\Controllers\ApiController@rentsCount' );
		// example: http://prixdesloyers.localhost/api/findRentsInBBox/36.03133177633187/-12.963867187499998/54.367758524068385/33.92578125
		$app->get(
			'rentsFindInBBox/{swLat:[0-9\.\-]+}/{swLng:[0-9\.\-]+}/{neLat:[0-9\.\-]+}/{neLng:[0-9\.\-]+}',
			'App\Http\Controllers\ApiController@rentsFindInBBox' );

	} );

