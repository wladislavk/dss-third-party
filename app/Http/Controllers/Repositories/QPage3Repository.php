<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Ds3\Contracts\QPage3Interface;
use Ds3\Eloquent\QPage3;

class QPage3Repository implements QPage3Interface
{
	public function get($patientId)
	{
		try {
			$qPage3 = QPage3::where('patientid', '=', $patientId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $qPage3;
	}
}