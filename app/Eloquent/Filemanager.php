<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Filemanager extends Model
{
	protected $table = 'filemanager';

	protected $fillable = ['docid', 'name', 'type', 'size', 'ext'];

	protected $primaryKey = 'id';

	public static function insertData($data)
	{
		$filemanager = new Filemanager();

		foreach ($data as $attribute => $value) {
			$filemanager->$attribute = $value;
		}

		try {
			$filemanager->save();
		} catch (QueryException $e) {
			return null;
		}

		return $filemanager->id;
	}
}