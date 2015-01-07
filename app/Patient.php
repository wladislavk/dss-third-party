<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Patient extends Model
{
	protected $table = 'dental_patients';

	protected $fillable = ['lastname', 'firstname'];

	protected $primaryKey = 'patientid';

	public static function get($valuesWhere)
	{
		$patients = new Patient();

		if (!empty($valuesWhere)) {
			foreach ($valuesWhere as $key => $value) {
				$patients = $patients->where($key, '=', $value);
			}
		} else {
			return false;
		}
		
		return $patients->get();
	}

	public static function getJoinPatients($docId)
	{
		$joinPatients = DB::table(DB::raw('dental_patients p2'))->join(DB::raw('dental_patients p'), 'p.patientid', '=', 'p2.parent_patientid')
											   ->whereRaw('p.docid = ' . $docId)
											   ->get();

		return $joinPatients;
	}

/*
	public function patientContact()
	{
		return $this->belongsTo('Ds3\PatientContact', 'patientid');
	}
*/

	public static function getPendingDuplicates($docId)
	{
		$pendingDuplicates = DB::table(DB::raw('dental_patients p'))->select('p.*')
																	->whereBetween('status', array(3, 4))
																	->where('docid', '=', $docId)
																	->whereRaw(DB::raw('(SELECT count(*) FROM dental_patients dp WHERE dp.status = 1 AND dp.docid = ' . $docId . ' AND
                 															((dp.firstname=p.firstname AND dp.lastname=p.lastname) OR (dp.add1 = p.add1 AND dp.city = p.city AND dp.state = p.state AND dp.zip = p.zip))) != 0'))
																	->get();

		return $pendingDuplicates;
	}
}