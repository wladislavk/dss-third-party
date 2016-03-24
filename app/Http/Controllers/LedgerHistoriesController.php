<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LedgerHistoryStore;
use DentalSleepSolutions\Http\Requests\LedgerHistoryUpdate;
use DentalSleepSolutions\Http\Requests\LedgerHistoryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\LedgerHistory;
use DentalSleepSolutions\Contracts\Repositories\LedgerHistories;

use Carbon\Carbon;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LedgerHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LedgerHistories $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerHistory $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LedgerHistory $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerHistories $resources
     * @param  \DentalSleepSolutions\Http\Requests\LedgerHistoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LedgerHistories $resources, LedgerHistoryStore $request)
    {
        $data = array_merge($request->all(), [
            'ip_address' => $request->ip(),
            'adddate'    => Carbon::now()->format('m/d/Y')
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerHistoryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LedgerHistory $resource, LedgerHistoryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerHistoryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LedgerHistory $resource, LedgerHistoryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
