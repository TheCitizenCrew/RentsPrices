<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class RentController extends BaseController
{
    public function edit()
    {

    	return view('rentEdit');
    }

    public function save(Request $request)
    {
    	$this->validate($request, \App\Models\Rent::$rules);
    	$rent = \App\Models\Rent::create($request->all());
    	return view('rentEdit');
    }
}
