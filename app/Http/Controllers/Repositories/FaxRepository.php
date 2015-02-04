<?php namespace Ds3\Repositories;

use Ds3\Contracts\FaxInterface;
use Ds3\Eloquent\Fax;

class FaxRepository implements FaxInterface
{
	public function getFaxAlerts($docId)
	{
		$faxAlerts = Fax::where('docid', '=', $docId)
					->where('viewed', '=', 0)
					->where('sfax_status', '=', 2)
					->get();

		return $faxAlerts;
	}
}