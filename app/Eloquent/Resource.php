<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Resource extends Model
{
	protected $table = 'dental_resources';

	protected $fillable = ['name', 'rank', 'docid'];

	protected $primaryKey = 'id';

	public static function get($where)
	{
		$resource = new Resource();

		foreach ($where as $attribute => $value) {
			$resource = $resource->where($attribute, '=', $value);
		}

		try {
			$resource = $resource->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $resource;
	}

	public static function getSelCheck($docId, $name, $ed)
	{
		$selCheck = Resource::where('docid', '=', $docId)->where('name', '=', $name)
														 ->where('id', '!=', $ed)
														 ->get();

		return $selCheck;
	}

	public static function updateData($ed, $values)
	{
		$resource = Resource::where('id', '=', $ed)->update($values);

		return $resource;
	}

	public static function insertData($data)
	{
		$resource = new Resource();

		foreach ($data as $attribute => $value) {
			$resource->$attribute = $value;
		}

		try {
			$resource->save();
		} catch (QueryException $e) {
			return null;
		}

		return $resource->id;
	}
}