<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Eloquent\Models\Payer as Resource;
use League\Fractal\TransformerAbstract;

class Payer extends TransformerAbstract
{
	public function transform(Resource $payer)
	{
	    return [
            //
	    ];
	}
}
