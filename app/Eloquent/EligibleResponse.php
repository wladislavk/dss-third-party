<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EligibleResponse extends Model
{
	protected $table = 'dental_eligible_response';

	protected $fillable = ['claimid', 'response', 'event_type'];

	protected $primaryKey = 'id';

	public static function get($where, $order = null)
	{
		$eligibleResponse = new EligibleResponse();

		foreach ($where as $attribute => $value) {
			$eligibleResponse = $eligibleResponse->where($attribute, '=', $value);
		}

		if (!empty($order)) {
			$eligibleResponse = $eligibleResponse->orderBy($order, 'desc');
		}

		return $eligibleResponse->get();
	}
}