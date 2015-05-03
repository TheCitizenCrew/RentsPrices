<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
  
class RentPrice extends Model
{
	protected $fillable = ['year', 'price'];
	
	public function rent()
	{
		return $this->belongsTo('App\Models\Rent');
	}

}
