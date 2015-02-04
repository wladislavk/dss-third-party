<?php namespace Ds3\Eloquent\Dentalsummfu;

use Illuminate\Database\Eloquent\Model;

class DentalsummfuEss extends Model
{
	protected $table = 'dentalsummfu_ess';

	protected $fillable = ['followupid', 'epworthid', 'answer'];

	protected $primaryKey = 'id';

	public static function insertData($data)
	{
		$dentalsummfuEss = new DentalsummfuEss();

		foreach ($data as $attribute => $value) {
			$dentalsummfuEss->$attribute = $value;
		}

		try {
			$dentalsummfuEss->save();
		} catch (QueryException $e) {
			return null;
		}

		return $dentalsummfuEss->followupid;
	}

	public static function deleteData($followupId)
	{
		$dentalsummfuEss = DentalsummfuEss::where('followupid', '=', $followupId)->delete();

		return $dentalsummfuEss;
	}
}