<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\TypeServiceStore;
use DentalSleepSolutions\Http\Requests\TypeServiceUpdate;
use DentalSleepSolutions\Http\Requests\TypeServiceDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\TypeService;
use DentalSleepSolutions\Contracts\Repositories\TypeServices;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class TypeServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TypeServices $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TypeServices $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TypeService $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TypeService $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TypeServices $resources
     * @param  \DentalSleepSolutions\Http\Requests\TypeServiceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TypeServices $resources, TypeServiceStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\TypeService $resource
     * @param  \DentalSleepSolutions\Http\Requests\TypeServiceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TypeService $resource, TypeServiceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TypeService $resource
     * @param  \DentalSleepSolutions\Http\Requests\TypeServiceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TypeService $resource, TypeServiceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
