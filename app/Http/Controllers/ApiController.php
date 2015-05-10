<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\RentPrice;

/**
 * 
 * @author cyrille
 */
class ApiController extends Controller
{
	public function rentsCount()
	{
		$stats = array(
			'rentsCount' => Rent::all()->count(),
			'rentPricesCount' => RentPrice::all()->count(),
		);
		return response()->json( $stats );
	}

	public function rentsFindInBBox( $swLat, $swLng, $neLat, $neLng)
	{
		$rents = Rent::bBox($swLat, $swLng, $neLat, $neLng)->get() ;
		return response()->json($rents);
	}

}
