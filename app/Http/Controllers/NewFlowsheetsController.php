<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\NewFlowsheetStore;
use DentalSleepSolutions\Http\Requests\NewFlowsheetUpdate;
use DentalSleepSolutions\Http\Requests\NewFlowsheetDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\NewFlowsheet;
use DentalSleepSolutions\Contracts\Repositories\NewFlowsheets;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class NewFlowsheetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\NewFlowsheets $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(NewFlowsheets $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\NewFlowsheet $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(NewFlowsheet $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\NewFlowsheets $resources
     * @param  \DentalSleepSolutions\Http\Requests\NewFlowsheetStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NewFlowsheets $resources, NewFlowsheetStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\NewFlowsheet $resource
     * @param  \DentalSleepSolutions\Http\Requests\NewFlowsheetUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NewFlowsheet $resource, NewFlowsheetUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\NewFlowsheet $resource
     * @param  \DentalSleepSolutions\Http\Requests\NewFlowsheetDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(NewFlowsheet $resource, NewFlowsheetDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
