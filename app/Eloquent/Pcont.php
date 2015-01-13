<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Pcont extends Model
{
	protected $table = 'dental_pcont';

	protected $fillable = ['patient_id', 'contact_id'];

	protected $primaryKey = 'id';

	public static function getPconts($patientId)
	{
		$pconts = Pcont::where('patient_id', '=', $patientId)->get();

		return $pconts;
	}

	public static function insertData($data)
	{
		$pcont = new Pcont();

		foreach ($data as $attribute => $value) {
			$pcont->$attribute = $value;
		}

		try {
			$pcont->save();
		} catch (QueryException $e) {
			return null;
		}

		return $pcont->id;
	}
}