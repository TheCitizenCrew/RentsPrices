<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Facades\Validator;
use Monolog\Handler\error_log;

class RentController extends BaseController
{

	public function show($id)
	{
		return view( 'rentShow', [ 'rent' => \App\Models\Rent::findOrFail( $id ) ] );
	}

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
		if( empty($id) )
		{
			$rent = new \App\Models\Rent();
		}
		else
		{
			$rent = \App\Models\Rent::findOrFail( $id );
			$rent->load('prices');
		}

		if( count($rent->prices) == 0 )
		{
			// Add an empty one
			$rentPrice = new \App\Models\RentPrice();
			$rent->prices[] = $rentPrice;
		}

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
		// Create a new Rent or retreive the one with $id

		if( empty($id) )
		{
			$rent = new \App\Models\Rent( $request->all() );
		}
		else
		{
			$rent = \App\Models\Rent::findOrFail( $id );
			$rent->fill( $request->all() );
			$rent->load('prices');
		}

		// to store the differents validators errors
		$errors = array ();

		// Rent validation

		$validator = Validator::make( $request->all(), \App\Models\Rent::$rules );
		if( $validator->fails() )
		{
			// return redirect()->back()->withErrors( $validator->errors() );
			$errors = array_merge( $errors, $validator->errors()->getMessages() );
		}

		// RentPrices validation

		$this->updateProcessRentPrices( $request, $rent, $errors );

		if( count( $errors ) > 0 )
		{
error_log( var_export($errors,true) );
			return view( 'rentEdit', [ 'rent' => $rent ] )->withErrors( $errors );
		}

		DB::transaction(
			function () use($rent)
			{
				$rent->push();
				//					$rent->prices()->saveMany( $rentPricesNew );
				//$rent->save();
			}
		);

		// Le saveMany() n'associe pas les nouveaux children, il faut reloader
		//$rent->load('prices');
		//return view( 'rentEdit', [ 'rent' => $rent ] );
		
		return  redirect('/rent/'.$rent->id);
	}

	protected function rentPriceFormatErrorMessage( array $errors, $rpIdx )
	{
		if( isset($errors['year']) )
		{
			$errors['year'.$rpIdx] = $errors['year'] ;
			unset($errors['year']);
		}
		if( isset($errors['price']) )
		{
			$errors['price'.$rpIdx] = $errors['price'] ;
			unset($errors['price']);
		}
		return $errors ;
	}

	/**
	 * Validate RentPrice data,
	 * rewrite error message's key,
	 * update $rent with modified RentPrices,
	 * store new RentPrices in $rentPricesNew.
	 *  
	 * @param Request $request
	 * @param \App\Models\Rent $rent
	 * @param string[] $errors
	 * @param array $rentPricesNew
	 */
	protected function updateProcessRentPrices( Request $request, \App\Models\Rent $rent, array &$errors )
	{
error_log(__METHOD__.' 1. rents->prices count = '.count($rent->prices));

		$rpIdx = 0 ;
		foreach( $request->get( 'rentprice' ) as $rp )
		{
error_log( $rpIdx.', year: '.$rp['year']);
			$validator = Validator::make( $rp, \App\Models\RentPrice::$rules );
			if( $validator->fails() )
			{
error_log( $rpIdx.', error year: '.$rp['year']);
				$errors = array_merge(
					$errors,
					$this->rentPriceFormatErrorMessage($validator->errors()->getMessages(), $rpIdx)
				);

			}

			if( !empty($rp['id']) )
			{
				foreach( $rent->prices as $price )
				{
					if( $price->id == $rp['id'] )
					{
						$price->fill( $rp );
					}
				}
			}
			else
			{
				// Add relation item without saving in DB !
				$rentPrice = new \App\Models\RentPrice( $rp );
				$rentPrice->rent_id = $rent->id ;
				$rent->prices[] = $rentPrice;
			}

			$rpIdx ++ ;
		}
		
error_log(__METHOD__.' 2. rents->prices count = '.count($rent->prices));
	}

}
