<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentPrice extends Model
{
	// https://github.com/thoughtsatire/revisionable
	use \Venturecraft\Revisionable\RevisionableTrait;

	// http://laravel.com/docs/5.0/eloquent#soft-deleting
	use SoftDeletes;

	protected $fillable = [
		'year',		
		'month',
		'price',
		'loads',
		'loadsOther',
		'loadsOtherText',
	];
	
	public static $rules = [
		'year'=>'required|integer',
		'month'=>'required|integer',
		'price'=>'required|numeric',
		'loads'=>'required|numeric',
		'loadsOther'=>'numeric'
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
