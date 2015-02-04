<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

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

	public static function insertData($data)
	{
		$flowPg1 = new FlowPg1();

		foreach ($data as $attribute => $value) {
			$flowPg1->$attribute = $value;
		}

		try {
			$flowPg1->save();
		} catch (QueryException $e) {
			return null;
		}

		return $flowPg1->id;
	}
}