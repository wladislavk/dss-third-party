<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
	protected $table = 'dental_complaint';

	protected $fillable = ['complaint', 'description', 'sortby', 'status'];

	protected $primaryKey = 'complaintid';

	public static function get($where)
	{
		$complaint = new Complaint();

		foreach ($where as $attribute => $value) {
			$complaint = $complaint->where($attribute, '=', $value);
		}

		try {
			$complaint = $complaint->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $complaint;
	}
}