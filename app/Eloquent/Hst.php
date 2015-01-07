<?php namespace Ds3;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Hst extends Model
{
	protected $table = 'dental_hst';

	protected $fillable = ['doc_id', 'user_id', 'company_id', 'patient_id', 'patient_firstname', 'patient_lastname'];

	protected $primaryKey = 'id';

	public static function get($viewed, $status, $valuesWhere)
	{
		$hst = DB::table('dental_hst')->whereRaw('(status IN (' . $status . '))')
									  ->whereRaw('(viewed IS NULL or viewed = ' . $viewed . ')');

		foreach ($valuesWhere as $key => $value) {
			$hst = $hst->where($key, '=', $value);
		}					  

		return $hst->get();
	}
}