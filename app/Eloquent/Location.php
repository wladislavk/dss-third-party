<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Location extends Model
{
	protected $table = 'dental_locations';

	protected $fillable = ['location', 'docid', 'name'];

	protected $primaryKey = 'id';

	public static function get($id)
	{
		try {
			$location = Location::where('id', '=', $id)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $location;
	}

	public static function updateData($id, $values)
	{
		$location = Location::where('id', '=', $id)->update($values);

		return $location;
	}

	public static function insertData($data)
	{
		$location = new Location();

		foreach ($data as $attribute => $value) {
			$location->$attribute = $value;
		}

		try {
			$location->save();
		} catch (QueryException $e) {
			return null;
		}

		return $location->id;
	}
}