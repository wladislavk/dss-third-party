<?php namespace Ds3\Eloquent\Claim;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class ClaimElectronic extends Model
{
	protected $table = 'dental_claim_electronic';

	protected $fillable = ['claimid', 'response', 'reference_id'];

	protected $primaryKey = 'id';

	public static function get($where, $order = null)
	{
		$claimElectronic = new ClaimElectronic();

		foreach ($where as $attribute => $value) {
			$claimElectronic = $claimElectronic->where($attribute, '=', $value);
		}

		if (!empty($order)) {
			$claimElectronic = $claimElectronic->orderBy($order, 'desc');
		}

		return $claimElectronic->get();
	}

	public static function insertData($data)
	{
		$claimElectronic = new ClaimElectronic();

		foreach ($data as $attribute => $value) {
			$claimElectronic->$attribute = $value;
		}

		try {
			$claimElectronic->save();
		} catch (QueryException $e) {
			return null;
		}

		return $claimElectronic->id;
	}
}