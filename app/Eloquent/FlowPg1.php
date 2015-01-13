<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class FlowPg1 extends Model
{
	protected $table = 'dental_flow_pg1';

	protected $fillable = ['copyreqdate', 'referred_by', 'thxletter'];

	protected $primaryKey = 'id';

	public static function get($patientId)
	{
		try {
			$flowPg1 = FlowPg1::where('pid', '=', $patientId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $flowPg1;
	}

	public static function updateData($id, $values)
	{
		$flowPg1 = FlowPg1::where('pid', '=', $id)->update($values);

		return $flowPg1;
	}
}