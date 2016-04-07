<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\FlowsheetStepStore;
use DentalSleepSolutions\Http\Requests\FlowsheetStepUpdate;
use DentalSleepSolutions\Http\Requests\FlowsheetStepDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\FlowsheetStep;
use DentalSleepSolutions\Contracts\Repositories\FlowsheetSteps;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class FlowsheetStepsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FlowsheetSteps $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FlowsheetSteps $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FlowsheetStep $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FlowsheetStep $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FlowsheetSteps $resources
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetStepStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FlowsheetSteps $resources, FlowsheetStepStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\FlowsheetStep $resource
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetStepUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FlowsheetStep $resource, FlowsheetStepUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FlowsheetStep $resource
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetStepDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FlowsheetStep $resource, FlowsheetStepDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
