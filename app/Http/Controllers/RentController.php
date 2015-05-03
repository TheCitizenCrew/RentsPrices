<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Facades\Validator;

class RentController extends BaseController
{

	/**
	 * Edit a new Rent.
	 *
	 * @return \Illuminate\View\View
	 */
	public function editNew()
	{
		return $this->edit( null );
	}

	/**
	 * Edit a new or an existing Rent.
	 *
	 * @param int $id        	
	 * @return \Illuminate\View\View
	 */
	public function edit( $id )
	{
		if( $id == null )
		{
			$rent = new \App\Models\Rent();
		}
		else
		{
			$rent = \App\Models\Rent::findOrFail( $id );
		}
		// error_log(var_export($rent, true));
		return view( 'rentEdit', [ 'rent' => $rent ] );
	}

	/**
	 * Save a new Rent and it's RentPrice(s).
	 *
	 * @param Request $request        	
	 * @return \Illuminate\View\View
	 */
	public function save( Request $request )
	{
		return $this->update( $request, null );
	}

	/**
	 * Update or Create a Rent and it's RentPrice(s).
	 *
	 * @param Request $request        	
	 * @param int $id        	
	 * @return \Illuminate\View\View
	 */
	public function update( Request $request, $id )
	{
		// Rent
		if( $id == null )
		{
			$rent = new \App\Models\Rent( $request->all() );
		}
		else
		{
			$rent = \App\Models\Rent::findOrFail( $id );
			$rent->fill( $request->all() );
		}

		$errors = array ();

		// Rent
		
		// $this->validate( $request, \App\Models\Rent::$rules );
		$validator = Validator::make( $request->all(), \App\Models\Rent::$rules );
		if( $validator->fails() )
		{
			// $this->throwValidationException( $request, $validator );
			// return redirect()->back()->withErrors( $validator->errors() );
			$errors = array_merge( $errors, $validator->errors()->getMessages() );
		}
		
		// RentPrices
		
		$rpos = array ();
		foreach( $request->get( 'rentprice' ) as $rp )
		{
			//$validator = $this->getValidationFactory()->make( $rp, \App\Models\RentPrice::$rules );
			$validator = Validator::make( $rp, \App\Models\RentPrice::$rules );

			if( $validator->fails() )
			{
				// $this->throwValidationException( $request, $validator );
				// return redirect()->back()->withErrors( $validator->errors(), 'rentprice'.count($rpos) );

				$errs = $validator->errors()->getMessages();
				$errs['year'.count($rpos)] = $errs['year'] ;
				unset($errs['year']);
				$errs['price'.count($rpos)] = $errs['price'] ;
				unset($errs['price']);
				error_log( var_export( $errs, true ) );
				
				$errors = array_merge( $errors, $errs );
			}
			$rpos[] = new \App\Models\RentPrice( $rp );
		}
		
		if( count( $errors ) == 0 )
		{
			DB::transaction( 
				function () use($rent ,$rpos)
				{
					$rent->save();
					$rent->prices()->saveMany( $rpos );
				} );
		}

		if( count( $errors ) > 0 )
		{
			return redirect()->back()->withErrors( $errors );
		}
		
		return view( 'rentEdit', [ 'rent' => $rent ] );
	}
}
