<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LedgerPaymentStore;
use DentalSleepSolutions\Http\Requests\LedgerPaymentUpdate;
use DentalSleepSolutions\Http\Requests\LedgerPaymentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\LedgerPayment;
use DentalSleepSolutions\Contracts\Repositories\LedgerPayments;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LedgerPaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerPayments $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LedgerPayments $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerPayment $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LedgerPayment $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerPayments $resources
     * @param  \DentalSleepSolutions\Http\Requests\LedgerPaymentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LedgerPayments $resources, LedgerPaymentStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerPayment $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerPaymentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LedgerPayment $resource, LedgerPaymentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerPayment $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerPaymentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LedgerPayment $resource, LedgerPaymentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
