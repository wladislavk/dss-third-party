<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SleepTestStore;
use DentalSleepSolutions\Http\Requests\SleepTestUpdate;
use DentalSleepSolutions\Http\Requests\SleepTestDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\SleepTest;
use DentalSleepSolutions\Contracts\Repositories\SleepTests;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SleepTestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SleepTests $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SleepTests $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SleepTest $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SleepTest $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SleepTests $resources
     * @param  \DentalSleepSolutions\Http\Requests\SleepTestStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SleepTests $resources, SleepTestStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\SleepTest $resource
     * @param  \DentalSleepSolutions\Http\Requests\SleepTestUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SleepTest $resource, SleepTestUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SleepTest $resource
     * @param  \DentalSleepSolutions\Http\Requests\SleepTestDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SleepTest $resource, SleepTestDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
