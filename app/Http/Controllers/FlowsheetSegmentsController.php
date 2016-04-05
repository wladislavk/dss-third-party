<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\FlowsheetSegmentStore;
use DentalSleepSolutions\Http\Requests\FlowsheetSegmentUpdate;
use DentalSleepSolutions\Http\Requests\FlowsheetSegmentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\FlowsheetSegment;
use DentalSleepSolutions\Contracts\Repositories\FlowsheetSegments;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class FlowsheetSegmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FlowsheetSegments $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FlowsheetSegments $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FlowsheetSegment $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FlowsheetSegment $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FlowsheetSegments $resources
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetSegmentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FlowsheetSegments $resources, FlowsheetSegmentStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FlowsheetSegment $resource
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetSegmentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FlowsheetSegment $resource, FlowsheetSegmentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FlowsheetSegment $resource
     * @param  \DentalSleepSolutions\Http\Requests\FlowsheetSegmentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FlowsheetSegment $resource, FlowsheetSegmentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
