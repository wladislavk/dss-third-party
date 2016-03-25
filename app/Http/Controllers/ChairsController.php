<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ChairStore;
use DentalSleepSolutions\Http\Requests\ChairUpdate;
use DentalSleepSolutions\Http\Requests\ChairDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Chair;
use DentalSleepSolutions\Contracts\Repositories\Chairs;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ChairsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Chairs $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Chairs $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Chair $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Chair $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Chairs $resources
     * @param  \DentalSleepSolutions\Http\Requests\ChairStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Chairs $resources, ChairStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Chair $resource
     * @param  \DentalSleepSolutions\Http\Requests\ChairUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Chair $resource, ChairUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Chair $resource
     * @param  \DentalSleepSolutions\Http\Requests\ChairDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Chair $resource, ChairDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
