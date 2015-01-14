<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class PlaceService extends Model
{
	protected $table = 'dental_place_service';

	protected $fillable = ['place_service', 'description', 'sortby', 'status'];

	protected $primaryKey = 'place_serviceid';

	public static function get()
	{
		$placeServices = PlaceService::where('status', '=', 1)->orderBy('sortby')
															  ->get();

		return $placeServices;
	}
}