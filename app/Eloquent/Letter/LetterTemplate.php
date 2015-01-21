<?php namespace Ds3\Eloquent\Letter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class LetterTemplate extends Model
{
	protected $table = 'dental_letter_templates';

	protected $fillable = ['name', 'template', 'body', 'default_letter'];

	protected $primaryKey = 'id';

	public static function get($id)
	{
		try {
			$letterTemplate = LetterTemplate::where('id', '=', $id)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $letterTemplate;
	}

	public static function insertData($data)
	{
		$letterTemplate = new LetterTemplate();

		foreach ($data as $attribute => $value) {
			$letterTemplate->$attribute = $value;
		}

		try {
			$letterTemplate->save();
		} catch (QueryException $e) {
			return null;
		}

		return $letterTemplate->id;
	}
}