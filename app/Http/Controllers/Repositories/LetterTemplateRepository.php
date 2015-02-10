<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\LetterTemplateInterface;
use Ds3\Eloquent\Letter\LetterTemplate;

class LetterTempalteRepository implements LetterTemplateInterface
{
	public function findLetterTemplate($id)
	{
		return LetterTemplate::find($id);
	}

	public function insertData($data)
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