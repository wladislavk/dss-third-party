<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\FlowsheetStore;
use DentalSleepSolutions\Http\Requests\FlowsheetUpdate;
use DentalSleepSolutions\Http\Requests\FlowsheetDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Flowsheet;
use DentalSleepSolutions\Contracts\Repositories\Flowsheets;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class FlowsheetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Flowsheets $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Flowsheets $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Flowsheet $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Flowsheet $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Flowsheets $resources
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Flowsheets $resources, FlowsheetStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Flowsheet $resource
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Flowsheet $resource, FlowsheetUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Flowsheet $resource
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Flowsheet $resource, FlowsheetDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
