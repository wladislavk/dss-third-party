<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Sleeplab extends Model
{
	protected $table = 'dental_sleeplab';

	protected $fillable = ['docid', 'salutation', 'lastname', 'firstname'];

	protected $primaryKey = 'sleeplabid';

	public static function get($where, $order = null)
	{
		$sleeplabs = new Sleeplab();

		foreach ($where as $attribute => $value) {
			$sleeplabs = $sleeplabs->where($attribute, '=', $value);
		}

		if (!empty($order)) {
			$sleeplabs = $sleeplabs->orderBy($order);
		}					 											 

		return $sleeplabs->get();;
	}

	public static function updateData($sleeplabId, $values)
	{
		$sleeplab = Sleeplab::where('sleeplabid', '=', $sleeplabId)->update($values);

		return $sleeplab;
	}

	public static function insertData($data)
	{
		$sleeplab = new Sleeplab();

		foreach ($data as $attribute => $value) {
			$sleeplab->$attribute = $value;
		}

		try {
			$sleeplab->save();
		} catch (QueryException $e) {
			return null;
		}

		return $sleeplab->sleeplabid;
	}
}