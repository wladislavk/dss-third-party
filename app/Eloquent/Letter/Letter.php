<?php namespace Ds3\Eloquent\Letter;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Letter extends Model
{
	protected $table = 'dental_letters';

	protected $fillable = ['patientid'];

	protected $primaryKey = 'letterid';

	public static function getGeneratedDates($valuesWhere)
	{
		$generatedDates = DB::table('dental_letters')->leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid');

		foreach ($valuesWhere as $key => $value) {
			$generatedDates = $generatedDates->where($key, '=', $value);
		}

		$generatedDates = $generatedDates->where(function($query)
										 {
											$query->whereNull('dental_letters.parentid')
												  ->orWhere('dental_letters.parentid', '=', '0');
										 })
										 ->orderBy('generated_date', 'asc')
										 ->get();

		return $generatedDates;
	}

	public static function getUnmailedLetters($docId)
	{
		$unmailedLetters = DB::table('dental_letters')->leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
													  ->where(function($query)
													  {
														$query->where('dental_letters.status', '=', '1')
															  ->orWhere('dental_letters.delivered', '=', '1');
													  })
													  ->whereNull('mailed_date')
													  ->where('dental_letters.deleted', '=', '0')
													  ->where('dental_letters.docid', '=', $docId)
													  ->get();

		return $unmailedLetters;
	}	

}