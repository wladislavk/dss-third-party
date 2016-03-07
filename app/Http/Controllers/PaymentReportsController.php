<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PaymentReportStore;
use DentalSleepSolutions\Http\Requests\PaymentReportUpdate;
use DentalSleepSolutions\Http\Requests\PaymentReportDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\PaymentReport;
use DentalSleepSolutions\Contracts\Repositories\PaymentReports;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PaymentReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PaymentReports $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PaymentReports $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PaymentReport $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PaymentReport $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PaymentReports $resources
     * @param  \DentalSleepSolutions\Http\Requests\PaymentReportStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PaymentReports $resources, PaymentReportStore $request)
    {
        $data = array_merge($request->all(), [
            'ip_address' => $request->ip()
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PaymentReport $resource
     * @param  \DentalSleepSolutions\Http\Requests\PaymentReportUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PaymentReport $resource, PaymentReportUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PaymentReport $resource
     * @param  \DentalSleepSolutions\Http\Requests\PaymentReportDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PaymentReport $resource, PaymentReportDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
