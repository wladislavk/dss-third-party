<?php

namespace DentalSleepSolutions\Http\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

class Payer extends TransformerAbstract
{
    /**
     * @param Collection|\DentalSleepSolutions\Eloquent\Models\Payer $payer
     * @return array
     */
	public function transform($payer)
	{
	    return [
            //
	    ];
	}
}
