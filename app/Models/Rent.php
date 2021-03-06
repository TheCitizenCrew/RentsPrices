<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rent extends Model
{
	// https://github.com/thoughtsatire/revisionable
	use \Venturecraft\Revisionable\RevisionableTrait;

	// http://laravel.com/docs/5.0/eloquent#soft-deleting
	use SoftDeletes;

	use DatePresenter ;
	/**
	 * The fillable property specifies which attributes should be mass-assignable.
	 * @var array
	 */
	protected $fillable = [
		//'id',	// FIXME : should not be there
		'buildingIndividual',
		'buildingStage',
		'buildingHLM',
		'buildingName',
		'street',
		'zipcode',
		'city',
		'country',
		'addrlat',
		'addrlng',
		'geolocManual', // automatic or manual address geolocalization
		'roomsCount',
		'kitchenRoom',
		'surfaceM2'
	];

	public static $rules = [
		'buildingIndividual'=>'required|boolean',
		'buildingHLM'=>'required|boolean',
		'street'=>'required',
		'zipcode'=>'required',
		'city'=>'required',
		'country'=>'required',
		'addrlat'=>'required|numeric',
		'addrlng'=>'required|numeric',
		'roomsCount'=>'numeric',
		'kitchenRoom'=>'boolean',
		'surfaceM2'=>'numeric',
	];

	/**
	 * Get Rent's RentPrice
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function prices()
	{
		return $this->hasMany('\App\Models\RentPrice');
	}

	/**
	 * A scope to geo selection with a bbox.
	 * 
	 * @param Illuminate\Database\Eloquent\Builder $query
	 * @param double $swLat
	 * @param double $swLng
	 * @param double $neLat
	 * @param double $neLng
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function scopeBBox($query, $swLat=0.0, $swLng=0.0, $neLat=0.0, $neLng=0.0)
	{
		return $query
			->where('addrLat', '>=', floatval($swLat) )
			->where('addrLng','>=', floatval($swLng) )
			->where('addrLat','<=', floatval($neLat) )
			->where('addrLng','<=', floatval($neLng) );
	}

}
