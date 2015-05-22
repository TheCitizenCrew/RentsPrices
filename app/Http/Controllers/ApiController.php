<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\RentPrice;

/**
 * 
 * @author cyrille
 */
class ApiController extends Controller
{
	public function rentsCount()
	{
		$stats = array(
			'rentsCount' => Rent::all()->count(),
			'rentPricesCount' => RentPrice::all()->count(),
		);
		return response()->json( $stats );
	}

	public function rentsFindInBBox( $swLat, $swLng, $neLat, $neLng)
	{
		$rents = Rent::bBox($swLat, $swLng, $neLat, $neLng)->get() ;
		$headers = array('Content-type'=> 'application/json; charset=utf-8', 'charset'=>'utf-8');
		return response()->json( $rents, 200, $headers, JSON_UNESCAPED_UNICODE );
	}

	public function rentsExport($format)
	{

		switch( $format )
		{

			case 'csv':

				$rentprices = RentPrice::all();
				$rentprices->load('rent');

				$csv = '' ;
				$csv .= self::rowheaders_2_csv($rentprices[0]->toArray())."\n";
				foreach ($rentprices as $row) {
					error_log( var_export($row->toArray(),true ));
					$csv .=  self::row_2_csv($row->toArray())."\n" ;
				}

				$filename = 'prixDesLoyers_'.date('Y-m-d-H-i-s');
				$headers = array(
					'Content-Type' => 'text/csv; charset=utf-8',
					'charset'=>'utf-8',
					'Content-Disposition' => 'attachment; filename="'.$filename.'.csv"',
				);
				return response( $csv, 200, $headers );
				break;

			case 'json':

				$rents = Rent::all();
				$rents->load('prices');
				$headers = array('Content-type'=> 'application/json; charset=utf-8', 'charset'=>'utf-8');
				return response()->json( $rents, 200, $headers, JSON_UNESCAPED_UNICODE );
				break;

			default:
				abort(501,'Export format not supported');
				break;
		}
	}

	static function rowheaders_2_csv($row) {
		$csv = '' ;
		foreach( $row as $k=>$v )
		{
			if( $v instanceof Arrayable )
			{
				$csv .= self::rowheaders_2_csv( $v->toArray() );
			}
			else if( is_array($v))
			{
				$csv .= self::rowheaders_2_csv( $v );
			}
			else
			{
				$csv .= ';'.$k ;
			}
		}
		return $csv ;
	}

	static function row_2_csv($row) {

		$csv = '' ;
		foreach( $row as $k=>$v )
		{
			if( $v instanceof Arrayable )
			{
				$csv .= self::row_2_csv( $v->toArray() );
			}
			else if( is_array($v))
			{
				$csv .= self::row_2_csv( $v );
			}
			else
			{
				$csv .= ';'.$v ;
			}
		}
		return $csv ;
	}

}
