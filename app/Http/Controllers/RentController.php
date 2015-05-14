<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Models\RentPrice;

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
			$errors = array_merge( $errors, $validator->errors()->getMessages() );
		}

		// RentPrices validation

		$rentPricesToDelete = $this->updateProcessRentPrices( $request, $rent, $errors );

		if( count( $errors ) > 0 )
		{
			return view( 'rentEdit', [ 'rent' => $rent ] )->withErrors( $errors );
		}

		DB::transaction(
			function () use($rent, $rentPricesToDelete)
			{
				$rent->push();
				RentPrice::destroy($rentPricesToDelete);
			}
		);
		
		return  redirect('/rent/'.$rent->id);
	}

	/**
	 * Remove unused relation item ((without touching the DB),
	 * Validate RentPrice data,
	 * rewrite error message's key to match input field postion
	 * update $rent with modified relation item (without touching the DB),
	 *  
	 * @param Request $request
	 * @param \App\Models\Rent $rent
	 * @param string[] $errors
	 * @return int[] ids to delete
	 */
	protected function updateProcessRentPrices( Request $request, \App\Models\Rent $rent, array &$errors )
	{
		$rentPricesToDelete = array();

		if( $request->get( 'rentprice' ) == null )
		{
			return $rentPricesToDelete ;
		}

		$rpIdx = 0 ;
		foreach( $request->get( 'rentprice' ) as $rp )
		{

			$allFieldsEmpty = true ;
			foreach( $rp as $k=>$v )
			{
				if( $k != 'id' && $v != '' )
				{
					$allFieldsEmpty = false ;
					break ;
				}
			}

			// If data empty, delete the item
			if( $allFieldsEmpty )
			{
				if( $rp['id'] > 0 )
				{
					// if data exists in DB, remember to delete it
					$rentPricesToDelete[] = $rp['id'];
					// and remove item from the rent
					foreach( $rent->prices as $k => $v )
					{
						if( $v->id == $rp['id'] )
						{
							unset($rent->prices[$k]);
						}
					}
				}
				// continue because it's a removed item
				continue ;
			}

			// Validate inputs

			$validator = Validator::make( $rp, \App\Models\RentPrice::$rules );
			if( $validator->fails() )
			{
				// Store validation errors
				$errors = array_merge(
					$errors,
					$this->rentPriceFormatErrorMessage($validator->errors()->getMessages(), $rpIdx)
				);

			}

			if( $rp['id'] > 0 )
			{
				// Update the existing rentPrice, without touching the DB !
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
				// Add new relation item without saving in DB !
				$rentPrice = new \App\Models\RentPrice( $rp );
				$rentPrice->rent_id = $rent->id ;
				$rent->prices[] = $rentPrice;
			}

			$rpIdx ++ ;
		}

		return $rentPricesToDelete ;
	}

	/**
	 * Suffixes error message key with $rpIdx to match item's form postion.
	 * 
	 * @param array $errors
	 * @param int $rpIdx
	 * @return array
	 */
	protected function rentPriceFormatErrorMessage( array $errors, $rpIdx )
	{

		foreach( $errors as $k => $v )
		{
			$errors[$k.$rpIdx] = $errors[$k] ;
			unset($errors[$k]);
		}

		return $errors ;
	}

}
