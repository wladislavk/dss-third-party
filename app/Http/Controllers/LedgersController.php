<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LedgerStore;
use DentalSleepSolutions\Http\Requests\LedgerUpdate;
use DentalSleepSolutions\Http\Requests\LedgerDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Ledger;
use DentalSleepSolutions\Contracts\Repositories\Ledgers;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LedgersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Ledgers $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Ledgers $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Ledger $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Ledger $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Ledgers $resources
     * @param  \DentalSleepSolutions\Http\Requests\LedgerStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Ledgers $resources, LedgerStore $request)
    {
        $data = array_merge($request->all(), [
            'ip_address' => $request->ip()
        ]);

        $resource = $resources->create($data);

        dd($resource->toArray());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Ledger $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Ledger $resource, LedgerUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Ledger $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Ledger $resource, LedgerDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
