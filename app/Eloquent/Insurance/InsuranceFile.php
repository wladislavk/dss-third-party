<?php namespace Ds3\Eloquent\Insurance;

use Illuminate\Database\Eloquent\Model;

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