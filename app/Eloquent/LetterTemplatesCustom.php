<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class LetterTemplatesCustom extends Model
{
	protected $table = 'dental_letter_templates_custom';

	protected $fillable = ['name', 'body', 'docid'];

	protected $primaryKey = 'id';

	public static function get($ed)
	{
		try {
			$letterTemplatesCustom = LetterTemplatesCustom::where('id', '=', $ed)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $letterTemplatesCustom;
	}

	public static function updateData($docId, $id, $values)
	{
		$letterTemplatesCustom = LetterTemplatesCustom::where('docid', '=', $docId)->where('id', '=', $id)
													 							   ->update($values);

		return $letterTemplatesCustom;
	}

	public static function insertData($data)
	{
		$letterTemplatesCustom = new LetterTemplatesCustom();

		foreach ($data as $attribute => $value) {
			$letterTemplatesCustom->$attribute = $value;
		}

		try {
			$letterTemplatesCustom->save();
		} catch (QueryException $e) {
			return null;
		}

		return $letterTemplatesCustom->id;
	}
}