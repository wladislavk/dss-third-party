<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class FlowPg2Info extends Model
{
	protected $table = 'dental_flow_pg2_info';

	protected $fillable = ['stepid', 'segmentid', 'letterid', 'description'];

	protected $primaryKey = 'id';

	public static function get($patientId)
	{
		$flowPg2Info = FlowPg2Info::where('patientid', '=', $patientId)->orderBy('date_completed', 'desc')
																	   ->orderBy('id', 'desc')
																	   ->get();

		return $flowPg2Info;
	}

	public static function insertData($data)
	{
		$flowPg2Info = new FlowPg2Info();

		foreach ($data as $attribute => $value) {
			$flowPg2Info->$attribute = $value;
		}

		try {
			$flowPg2Info->save();
		} catch (QueryException $e) {
			return null;
		}

		return $flowPg2Info->id;
	}

	public static function updateData($patientId, $values)
	{
		$flowPg2Info = FlowPg2Info::where('patientid', '=', $patientId)->where('stepid', '=', 1)
																	   ->update($values);

		return $flowPg2Info;
	}
}