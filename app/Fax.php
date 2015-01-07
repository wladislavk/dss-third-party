<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Fax extends Model
{
	protected $table = 'dental_faxes';

	protected $fillable = ['patientid', 'userid', 'docid', 'pages', 'contactid'];

	protected $primaryKey = 'id';

	public static function getFaxAlerts($docId)
	{
		$faxAlerts = Fax::where('docid', '=', $docId)->where('viewed', '=', 0)
													 ->where('sfax_status', '=', 2)
													 ->get();

		return $faxAlerts;
	}
}