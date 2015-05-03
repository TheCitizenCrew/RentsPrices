<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input ;
use DB ;

class RentController extends BaseController
{
    public function editNew()
    {
    	//$rent = \App\Models\Rent::find();
    	$rent = new \App\Models\Rent();
    	return view('rentEdit', ['rent'=>$rent]);
    }

    public function edit($id)
    {
    	$rent = \App\Models\Rent::find($id);
    	return view('rentEdit', ['rent'=>$rent]);
    }
    
    public function save(Request $request)
    {
 error_log( var_export($request->all(),true));
 
     	DB::transaction(function() use($request){

     		$this->validate($request, \App\Models\Rent::$rules);
     		$rent = \App\Models\Rent::create($request->all() );
     		
     		/*
     		 * remap les champs html en tableaux compatible avec le model RentPrice
     		 Input :
     		 'rentprice' =>
     		 array (
     		 'year' =>
     		 array (
     		 0 => '1',
     		 1 => '3',
     		 ),
     		 'price' =>
     		 array (
     		 0 => '2',
     		 1 => '4',
     		 ),
     		 ),
     		
     		 Output :
     		 array (
     		 0 =>
     		 array (
     		 'year' => '1',
     		 'price' => '2',
     		 ),
     		 1 =>
     		 array (
     		 'year' => '3',
     		 'price' => '4',
     		 ),
     		 )
     		
     		*/
     		$rp = $request->get('rentprice');
     		$rentPrices = array();
     		foreach( ['year','price'] as $k )
     		{
     			$i=0;
     			foreach( $rp[$k] as $v )
     			{
     				if( ! isset($rentPrices[$i]))
     					$rentPrices[$i] = array();
     				$rentPrices[$i][$k] = $v ;
     				$i++;
     			}
     		}
     		
     		foreach( $rentPrices as $rp )
     		{
     			$this->validate($rp, \App\Models\RentPrice::$rules);
     			$rp->id = $rent->id ;
 	    		$rent = \App\Models\Rent::create($rp);
     		}

    	}); // transaction

    	return view('rentEdit');
    }
}
