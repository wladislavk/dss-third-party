<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class FlowPg2 extends Model
{
	protected $table = 'dental_flow_pg2';

	protected $fillable = ['steparray'];

	protected $primaryKey = 'id';

	public static function getStep($patientId)
	{
		try {
			$step = FlowPg2::where('patientid', '=', $patientId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $step; 
	}
}