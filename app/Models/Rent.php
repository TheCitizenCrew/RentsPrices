<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
	/**
	 * The fillable property specifies which attributes should be mass-assignable.
	 * @var array
	 */
	protected $fillable = ['id', 'buildingIndividual', 'buildingStage', 'buildingName', 'street', 'zipcode', 'city'];

	public static $rules = [
		'buildingIndividual'=>'required|boolean',
		'buildingStage'=>'',
		'buildingName'=>'',
		'street'=>'required',
		'zipcode'=>'required',
		'city'=>'required'
	];

	/**
	 * Get Rent's RentPrices
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function prices()
	{
		return $this->hasMany('\App\Models\RentPrice');
	}
}
