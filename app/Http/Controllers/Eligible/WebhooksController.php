<?php

namespace DentalSleepSolutions\Http\Controllers\Eligible;

use Exception;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eligible\Webhooks\ClaimsHandler;
use DentalSleepSolutions\Eligible\Webhooks\PayersHandler;
use DentalSleepSolutions\Eligible\Webhooks\PaymentsHandler;
use DentalSleepSolutions\Eligible\Webhooks\EnrollmentsHandler;
use DentalSleepSolutions\Http\Controllers\Api\ApiBaseController;

class WebhooksController extends ApiBaseController
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function enrollment(Request $request)
    {
        $handler = new EnrollmentsHandler;

        return $handler->processing($request);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function claims(Request $request)
    {
        $handler = new ClaimsHandler();

        return $handler->processing($request);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function payment(Request $request)
    {
        $handler = new PaymentsHandler();

        return $handler->processing($request);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function payers(Request $request)
    {
        $handler = new PayersHandler();

        return $handler->processing($request);
    }
}
