<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Eloquent\PaymentReport as Resource;
use League\Fractal\TransformerAbstract;

class PaymentReport extends TransformerAbstract
{
	public function transform(Resource $payment_report)
	{
	    return [
            //
	    ];
	}
}
