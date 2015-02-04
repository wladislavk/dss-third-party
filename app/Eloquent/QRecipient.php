<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class QRecipient extends Model
{
	protected $table = 'dental_q_recipients';

	protected $fillable = ['formid', 'patientid', 'userid', 'docid', 'status'];

	protected $primaryKey = 'q_recipientsid';

	public static function get($patientId)
	{
		try {
			$qRecipient = QRecipient::where('patientid', '=', $patientId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $qRecipient;
	}
}