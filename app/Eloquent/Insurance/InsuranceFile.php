<?php namespace Ds3\Eloquent\Insurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class InsuranceFile extends Model
{
	protected $table = 'dental_insurance_file';

	protected $fillable = ['claimid', 'claimtype', 'filename', 'status'];

	protected $primaryKey = 'id';

	public static function get($claimId, $status)
	{
		$insuranceFiles = InsuranceFile::where('claimid', '=', $claimId)->whereRaw('(status IN (' . $status . '))')
																	    ->get();

		return $insuranceFiles;
	}


}