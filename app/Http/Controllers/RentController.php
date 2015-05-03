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

		// Create a new Rent or retreive the one with $id
		if( $id == null )
		{
			$rent = new \App\Models\Rent( $request->all() );
		}
		else
		{
			$rent = \App\Models\Rent::findOrFail( $id );
			$rent->fill( $request->all() );
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

		$rentPricesNew = array ();
		$this->updateProcessRentPrices( $request, $rent, $errors, $rentPricesNew );

		if( count( $errors ) == 0 )
		{
			DB::transaction( 
				function () use(&$rent ,$rentPricesNew)
				{
					$rent->push();
					$rent->prices()->saveMany( $rentPricesNew );
				} );
		}
		else
		{
			return redirect()->back()->withErrors( $errors );
		}

		// Le saveMany() n'associe pas les nouveaux children, il faut reloader
		//$rent->load('prices');
		//return view( 'rentEdit', [ 'rent' => $rent ] );

		return redirect()->back();
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
	protected function updateProcessRentPrices( Request $request, \App\Models\Rent $rent, array &$errors, array &$rentPricesNew )
	{
		foreach( $request->get( 'rentprice' ) as $rp )
		{
			$validator = Validator::make( $rp, \App\Models\RentPrice::$rules );
			if( $validator->fails() )
			{
				// return redirect()->back()->withErrors( $validator->errors(), 'rentprice'.count($rpos) );
		
				$errs = $validator->errors()->getMessages();

				if( isset($errs['year']) )
				{
					$errs['year'.count($rentPricesNew)] = $errs['year'] ;
					unset($errs['year']);
				}
				if( isset($errs['price']) )
				{
					$errs['price'.count($rentPricesNew)] = $errs['price'] ;
					unset($errs['price']);
				}
		
				$errors = array_merge( $errors, $errs );
			}
				
			$o = new \App\Models\RentPrice( $rp );
			if( !empty($o->id) )
			{
				foreach( $rent->prices as $price )
				{
					// pour que l'id soit affecté, il faut l'ajouter dans Model::$fillable
					if( $price->id == $o->id )
					{
						$price->fill( $o->toArray() );
					}
				}
			}
			else
			{
				// un id null fait planter le sql de saveMany()
				unset( $o->id );
				$rentPricesNew[] = $o;
			}
		
		}
		
	}

}
