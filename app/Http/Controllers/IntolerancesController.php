<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\IntoleranceStore;
use DentalSleepSolutions\Http\Requests\IntoleranceUpdate;
use DentalSleepSolutions\Http\Requests\IntoleranceDestroy;
use DentalSleepSolutions\Contracts\Resources\Intolerance;
use DentalSleepSolutions\Contracts\Repositories\Intolerances;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class IntolerancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Intolerances $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Intolerances $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Intolerance $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Intolerance $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Intolerances $resources
     * @param  \DentalSleepSolutions\Http\Requests\IntoleranceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Intolerances $resources, IntoleranceStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Intolerance $resource
     * @param  \DentalSleepSolutions\Http\Requests\IntoleranceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Intolerance $resource, IntoleranceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Intolerance $resource
     * @param  \DentalSleepSolutions\Http\Requests\IntoleranceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Intolerance $resource, IntoleranceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
