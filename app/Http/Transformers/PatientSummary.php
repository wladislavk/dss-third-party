<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Eloquent\PatientSummary as Resource;
use League\Fractal\TransformerAbstract;

class PatientSummary extends TransformerAbstract
{
	public function transform(Resource $patient_summary)
	{
	    return [
            //
	    ];
	}
}
