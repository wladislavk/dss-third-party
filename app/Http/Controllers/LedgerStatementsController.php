<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LedgerStatementStore;
use DentalSleepSolutions\Http\Requests\LedgerStatementUpdate;
use DentalSleepSolutions\Http\Requests\LedgerStatementDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\LedgerStatement;
use DentalSleepSolutions\Contracts\Repositories\LedgerStatements;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LedgerStatementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerStatements $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LedgerStatements $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerStatement $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LedgerStatement $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerStatements $resources
     * @param  \DentalSleepSolutions\Http\Requests\LedgerStatementStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LedgerStatements $resources, LedgerStatementStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerStatement $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerStatementUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LedgerStatement $resource, LedgerStatementUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerStatement $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerStatementDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LedgerStatement $resource, LedgerStatementDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
