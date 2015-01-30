<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class InsDiagnosis extends Model
{
	protected $table = 'dental_ins_diagnosis';

	protected $fillable = ['ins_diagnosis', 'description', 'sortby', 'status'];

	protected $primaryKey = 'ins_diagnosisid';

	public static function get()
	{
		$insDiagnosis = InsDiagnosis::where('status', '=', 1)->orderBy('sortby')
															 ->get();

		return $insDiagnosis;
	}
}