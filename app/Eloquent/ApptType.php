<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\DB;

class ApptType extends Model
{
	protected $table = 'dental_appt_types';

	protected $fillable = ['name', 'color', 'classname'];

	protected $primaryKey = 'id';

	public static function get($where, $order = null)
	{
		$apptType = new ApptType();

		foreach ($where as $attribute => $value) {
			$apptType = $apptType->where($attribute, '=', $value);
		}

		if (!empty($order)) {
			$apptType = $apptType->orderBy($order);
		}

		return $apptType->get();
	}

	public static function getSelCheck($docId, $name, $className, $ed)
	{
		$selCheck = ApptType::where('docid', '=', $docId)->whereRaw("(name = '" . $name . "' or classname = '" . $className . "')")
													   	 ->where('id', '!=', $ed)
													     ->get();

		return $selCheck;
	}

	public static function updateData($ed, $values)
	{
		$apptType = ApptType::where('id', '=', $ed)->update($values);

		return $apptType;
	}

	public static function insertData($data)
	{
		$apptType = new ApptType();

		foreach ($data as $attribute => $value) {
			$apptType->$attribute = $value;
		}

		try {
			$apptType->save();
		} catch (QueryException $e) {
			return null;
		}

		return $apptType->id;
	}
}