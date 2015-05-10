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

	public function scopeBBox($query, $swLat=0, $swLng=0, $neLat=0, $neLng=0)
	{
		//$sql = 'SELECT * FROM ' . $table . ' WHERE geo_lat >= ' . floatval($swLat) . ' and geo_lon >= ' . floatval($swLon)
		//. ' and geo_lat <= ' . floatval($neLat) . ' and geo_lon <= ' . floatval($neLon) . ' ';
		
		
		return $query
			->where('addrLat', '>=', floatval($swLat) )
			->where('addrLng','>=', floatval($swLng) )
			->where('addrLat','<=', floatval($neLat) )
			->where('addrLng','<=', floatval($neLng) );

	}

}
