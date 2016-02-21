<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LedgerPaymentHistoryStore;
use DentalSleepSolutions\Http\Requests\LedgerPaymentHistoryUpdate;
use DentalSleepSolutions\Http\Requests\LedgerPaymentHistoryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\LedgerPaymentHistory;
use DentalSleepSolutions\Contracts\Repositories\LedgerPaymentHistories;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LedgerPaymentHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerPaymentHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LedgerPaymentHistories $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerPaymentHistory $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LedgerPaymentHistory $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerPaymentHistories $resources
     * @param  \DentalSleepSolutions\Http\Requests\LedgerPaymentHistoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LedgerPaymentHistories $resources, LedgerPaymentHistoryStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerPaymentHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerPaymentHistoryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LedgerPaymentHistory $resource, LedgerPaymentHistoryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerPaymentHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerPaymentHistoryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LedgerPaymentHistory $resource, LedgerPaymentHistoryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
