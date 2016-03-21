<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SoftPalateStore;
use DentalSleepSolutions\Http\Requests\SoftPalateUpdate;
use DentalSleepSolutions\Http\Requests\SoftPalateDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\SoftPalate;
use DentalSleepSolutions\Contracts\Repositories\SoftPalates;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SoftPalatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SoftPalates $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SoftPalates $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SoftPalate $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SoftPalate $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SoftPalates $resources
     * @param  \DentalSleepSolutions\Http\Requests\SoftPalateStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SoftPalates $resources, SoftPalateStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\SoftPalate $resource
     * @param  \DentalSleepSolutions\Http\Requests\SoftPalateUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SoftPalate $resource, SoftPalateUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SoftPalate $resource
     * @param  \DentalSleepSolutions\Http\Requests\SoftPalateDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SoftPalate $resource, SoftPalateDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
