<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;

class RentController extends BaseController
{

	public function editNew()
	{
		return $this->edit( null );
	}

	/**
	 * Edit a new or an existing Rent.
	 *
	 * @param string $id        	
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
	 * Save a Rent and it's RentPrice(s).
	 *
	 * @param Request $request        	
	 * @return \Illuminate\View\View
	 */
	public function save( Request $request )
	{
		return $this->update( $request, null );
	}

	public function update( Request $request, $id )
	{
		DB::transaction( 
			function () use($request )
			{
				
				// Rent
				$this->validate( $request, \App\Models\Rent::$rules );
				if( $id == null )
				{
					$rent = \App\Models\Rent::create( $request->all() );
				}
				else
				{
					$rent = \App\Models\Rent::findOrFail( $id );
					$rent->fill( $request->all() );
				}
				
				$rpos = array ();
				// RentPrices
				foreach( $request->get( 'rentprice' ) as $rp )
				{
					$validator = $this->getValidationFactory()->make( $rp, 
						\App\Models\RentPrice::$rules );
					if( $validator->fails() )
					{
						$this->throwValidationException( $request, $validator );
					}
					$rpos[] = new \App\Models\RentPrice( $rp );
				}
				$rent->prices()->saveMany( $rpos );
			} );
		
		return view( 'rentEdit', [ 'rent' => $rent ] );
	}
}
