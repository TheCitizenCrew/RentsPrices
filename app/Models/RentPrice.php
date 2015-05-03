<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
  
class RentPrice extends Model
{
	protected $fillable = ['id', 'year', 'price'];
	
	public static $rules = [
			'year'=>'required|numeric',
			'price'=>'required|numeric'
	];

	/**
	 * Touching belongsTo Parent Timestamps.
	 * http://laravel.com/docs/5.0/eloquent#touching-parent-timestamps
	 * 
	 * @var string[]
	 */
	protected $touches = ['rent'];

	public function rent()
	{
		return $this->belongsTo('\App\Models\Rent');
	}

}
