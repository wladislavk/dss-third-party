<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LedgerRecordStore;
use DentalSleepSolutions\Http\Requests\LedgerRecordUpdate;
use DentalSleepSolutions\Http\Requests\LedgerRecordDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\LedgerRecord;
use DentalSleepSolutions\Contracts\Repositories\LedgerRecords;

use Carbon\Carbon;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LedgerRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerRecords $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LedgerRecords $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerRecord $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LedgerRecord $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerRecords $resources
     * @param  \DentalSleepSolutions\Http\Requests\LedgerRecordStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LedgerRecords $resources, LedgerRecordStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerRecord $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerRecordUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LedgerRecord $resource, LedgerRecordUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerRecord $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerRecordDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LedgerRecord $resource, LedgerRecordDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
