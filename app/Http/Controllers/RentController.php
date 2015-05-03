<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input ;
use DB ;

class RentController extends BaseController
{

	/**
	 * Edit a new or an existing Rent.
	 * 
	 * @param string $id
	 * @return \Illuminate\View\View
	 */
    public function edit($id=null)
    {
    	if( $id==null)
    	{
    		$rent = new \App\Models\Rent();
    	}
    	else
    	{
    		$rent = \App\Models\Rent::find($id);
    	}
    	return view('rentEdit', ['rent'=>$rent]);
    }

    /**
     * Save a Rent and it's RentPrice(s).
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function save(Request $request)
    {
    	$rent = new \App\Models\Rent();

    	DB::transaction(function() use($request){
    	
    		// Rent
     		$this->validate($request, \App\Models\Rent::$rules);
     		$rent = \App\Models\Rent::create($request->all() );

     		$rpos=array();
     		// RentPrices
     		foreach( $request->get('rentprice') as $rp )
     		{
     			$validator = $this->getValidationFactory()->make($rp, \App\Models\RentPrice::$rules );
     			if ($validator->fails()) {
     				$this->throwValidationException($request, $validator);
     			}
     			$rpos[] = new \App\Models\RentPrice($rp);
     		}
     		$rent->prices()->saveMany($rpos);
    	});

    	return view('rentEdit', ['rent'=>$rent]);
    }

}
