<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Pcont extends Model
{
	protected $table = 'dental_pcont';

	protected $fillable = ['patient_id', 'contact_id'];

	protected $primaryKey = 'id';

	public static function getPconts($patientId)
	{
		$pconts = Pcont::where('patient_id', '=', $patientId)->get();

		return $pconts;
	}

	public static function getJoin($patientId)
	{
		$union = DB::table('dental_contact')->leftJoin('dental_pcont', 'dental_pcont.contact_id', '=', 'dental_contact.contactid')
											->where('dental_pcont.patient_id', '=', $patientId);

		$pcont = DB::table('dental_pcont')->leftJoin('dental_contact', 'dental_pcont.contact_id', '=', 'dental_contact.contactid')
										  ->where('dental_pcont.patient_id', '=', $patientId)
										  ->union($union)
										  ->get();

		return $pcont;
	}

	public static function insertData($data)
	{
		$pcont = new Pcont();

		foreach ($data as $attribute => $value) {
			$pcont->$attribute = $value;
		}

		try {
			$pcont->save();
		} catch (QueryException $e) {
			return null;
		}

		return $pcont->id;
	}
}