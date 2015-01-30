<?php namespace Ds3\Eloquent\Dentalsummfu;

use Illuminate\Database\Eloquent\Model;

class Dentalsummfu extends Model
{
	protected $table = 'dentalsummfu';

	protected $fillable = ['patientid', 'devadd', 'dsetadd'];

	protected $primaryKey = 'followupid';

	public static function get($patientId, $order)
	{
		$dentalsummfu = Dentalsummfu::where('patientid', '=', $patientId)->orderBy($order, 'desc')
																		 ->get();

		return $dentalsummfu;
	}

	public static function updateData($followupId, $values)
	{
		$dentalsummfu = Dentalsummfu::where('followupid', '=', $followupId)->update($values);

		return $dentalsummfu;
	}

	public static function insertData($data)
	{
		$dentalsummfu = new Dentalsummfu();

		foreach ($data as $attribute => $value) {
			$dentalsummfu->$attribute = $value;
		}

		try {
			$dentalsummfu->save();
		} catch (QueryException $e) {
			return null;
		}

		return $dentalsummfu->followupid;
	}

	public static function deleteData($followupId)
	{
		$dentalsummfu = Dentalsummfu::where('followupid', '=', $followupId)->delete();

		return $dentalsummfu;
	}
}