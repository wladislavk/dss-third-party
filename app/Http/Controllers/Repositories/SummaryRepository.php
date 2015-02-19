<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\SummaryInterface;
use Ds3\Eloquent\Summary;

class SummaryRepository implements SummaryInterface
{
	public function get($patientId)
	{
		$summary = Summary::where('patientid', '=', $patientId)->get();

		return $summary;
	}

	public function updateData($where, $values)
	{
		$summary = new Summary();

		foreach ($where as $attribute => $value) {
			$summary = $summary->where($attribute, '=', $value);
		}

		$summary = $summary->update($values);

		return $summary;
	}

	public function insertData($data)
	{
		$summary = new Summary();

		foreach ($data as $attribute => $value) {
			$summary->$attribute = $value;
		}

		try {
			$summary->save();
		} catch (ModelNotFoundException $e) {
			return null;
		}

		return $summary->summaryid;
	}
}