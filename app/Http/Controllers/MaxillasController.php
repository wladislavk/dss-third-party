<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\MaxillaStore;
use DentalSleepSolutions\Http\Requests\MaxillaUpdate;
use DentalSleepSolutions\Http\Requests\MaxillaDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Maxilla;
use DentalSleepSolutions\Contracts\Repositories\Maxillas;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class MaxillasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Maxillas $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Maxillas $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Maxilla $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Maxilla $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Maxillas $resources
     * @param  \DentalSleepSolutions\Http\Requests\MaxillaStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Maxillas $resources, MaxillaStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Maxilla $resource
     * @param  \DentalSleepSolutions\Http\Requests\MaxillaUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Maxilla $resource, MaxillaUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Maxilla $resource
     * @param  \DentalSleepSolutions\Http\Requests\MaxillaDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Maxilla $resource, MaxillaDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
