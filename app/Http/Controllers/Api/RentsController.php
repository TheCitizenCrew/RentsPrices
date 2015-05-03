<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\RentPrice;

/*
 *
 * Table::findOrFail($id)
 *	Retrieving A Model By Primary Key Or Throw An Exception ModelNotFoundException
 */

/**
 * 
 * @author cyrille
 *
 */
class RentsController extends Controller
{
	public function find(Request $request)
	{
		$out = array();
		
		$rents = Rent::all() ;
		$out[] = $rents ;
		if( $request->get('full') )
		{
			// Lazy Eager Loading
			$rents->load('prices');
		}

		return response()->json($out);
	}

	public function show($id)
	{
		return view('rent');
	}

	public function save()
	{
	}

	public function delete()
	{
	}

}
