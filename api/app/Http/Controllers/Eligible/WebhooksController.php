<?php

namespace DentalSleepSolutions\Http\Controllers\Eligible;

use DentalSleepSolutions\Eloquent\Repositories\EligibleResponseRepository;
use DentalSleepSolutions\Eloquent\Repositories\Enrollments\EnrollmentRepository;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eligible\Webhooks\ClaimsHandler;
use DentalSleepSolutions\Eligible\Webhooks\PayersHandler;
use DentalSleepSolutions\Eligible\Webhooks\PaymentsHandler;
use DentalSleepSolutions\Eligible\Webhooks\EnrollmentsHandler;
use DentalSleepSolutions\Http\Controllers\Api\ApiBaseController;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class WebhooksController extends ApiBaseController
{
    /**
     * @param  \Illuminate\Http\Request $request
     * @param EligibleResponseRepository $eligibleResponseRepository
     * @param EnrollmentRepository $enrollmentRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function enrollment(
        Request $request,
        EligibleResponseRepository $eligibleResponseRepository,
        EnrollmentRepository $enrollmentRepository
    ) {
        $handler = new EnrollmentsHandler($eligibleResponseRepository, $enrollmentRepository);

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
