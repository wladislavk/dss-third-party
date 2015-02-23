<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\SleeplabInterface;
use Ds3\Eloquent\Sleeplab;

class SleeplabRepository implements SleeplabInterface
{
	public function get($where, $order = null)
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

	public function updateData($sleeplabId, $values)
	{
		$sleeplab = Sleeplab::where('sleeplabid', '=', $sleeplabId)->update($values);

		return $sleeplab;
	}

	public function insertData($data)
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