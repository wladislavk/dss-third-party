<?php namespace Ds3\Eloquent;

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
}