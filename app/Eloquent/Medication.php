<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
	protected $table = 'dental_medications';

	protected $fillable = ['medications', 'description', 'sortby', 'status'];

	protected $primaryKey = 'medicationsid';

	public static function get($medicationsId)
	{
		try {
			$medication = Medication::where('medicationsid', '=', $medicationsId)->where('status', '=', 1)
																				 ->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $medication;
	}
}