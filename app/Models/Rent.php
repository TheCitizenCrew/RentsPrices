<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
	use DatePresenter ;
	/**
	 * The fillable property specifies which attributes should be mass-assignable.
	 * @var array
	 */
	protected $fillable = ['id', 'buildingIndividual', 'buildingStage', 'buildingName', 'street', 'zipcode', 'city', 'country', 'addrlat', 'addrlng'];

	public static $rules = [
		'buildingIndividual'=>'required|boolean',
		'buildingStage'=>'',
		'buildingName'=>'',
		'street'=>'required',
		'zipcode'=>'required',
		'city'=>'required',
		'country'=>'required',
		'addrlat'=>'required',
		'addrlng'=>'required'
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
