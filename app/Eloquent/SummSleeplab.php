<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class SummSleeplab extends Model
{
	protected $table = 'dental_summ_sleeplab';

	protected $fillable = ['sleeptesttype', 'place'];

	protected $primaryKey = 'id';

	public static function getSleepStudies($patientId)
	{
		$sleepStudies = DB::table(DB::raw('dental_summ_sleeplab ss'))->join(DB::raw('dental_patients p'), 'ss.patiendid', '=', 'p.patientid')
																	 ->where(function($query){
																	 	$query->where('p.p_m_ins_type', '!=', 1)
																	 		  ->orWhere(function($query){
																	 		  	$query->where(function($query){
																	 		  			$query->whereRaw('ss.diagnosising_doc IS NOT NULL')
																	 		  			  	  ->where('ss.diagnosising_doc', '!=', '');
																	 		  		  })
																	 		  		  ->where(function($query){
																	 		  		  	$query->whereRaw('ss.diagnosising_npi IS NOT NULL')
																	 		  		  		  ->where('ss.diagnosising_npi', '!=', '');
																	 		  		  });
																	 		  });
																	 })
																	 ->where(function($query){
																	 	$query->whereRaw('ss.diagnosis IS NOT NULL')
																	 		  ->where('ss.diagnosis', '!=', '');
																	 })
																	 ->where('ss.completed', '=', 'Yes')
																	 ->whereRaw('ss.filename IS NOT NULL')
																	 ->where('ss.patiendid', '=', $patientId)
																	 ->first();

		return $sleepStudies;
	}

	public static function insertData($data)
	{
		$summSleeplab = new SummSleeplab();

		foreach ($data as $attribute => $value) {
			$summSleeplab->$attribute = $value;
		}

		try {
			$summSleeplab->save();
		} catch (QueryException $e) {
			return null;
		}

		return $summSleeplab->id;
	}
}