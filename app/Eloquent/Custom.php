<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Custom extends Model
{
	protected $table = 'dental_custom';

	protected $fillable = ['title', 'description', 'docid', 'status'];

	protected $primaryKey = 'customid';

	public static function get($customId)
	{
		try {
			$custom = Custom::where('customid', '=', $customId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $custom;
	}

	public static function getTotalRecords($docId)
	{
		$totalRecords = Custom::where('docid', '=', $docId)->orderBy('title')
														   ->get();

		return $totalRecords;
	}

	public static function updateData($customId, $values)
	{
		$custom = Custom::where('customid', '=', $customId)->update($values);

		return $custom;
	}

	public static function insertData($data)
	{
		$custom = new Custom();

		foreach ($data as $attribute => $value) {
			$custom->$attribute = $value;
		}

		try {
			$custom->save();
		} catch (QueryException $e) {
			return null;
		}

		return $custom->customid;
	}
}