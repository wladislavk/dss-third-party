<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\TongueStore;
use DentalSleepSolutions\Http\Requests\TongueUpdate;
use DentalSleepSolutions\Http\Requests\TongueDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Tongue;
use DentalSleepSolutions\Contracts\Repositories\Tongues;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class TonguesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Tongues $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Tongues $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Tongue $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tongue $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Tongues $resources
     * @param  \DentalSleepSolutions\Http\Requests\TongueStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Tongues $resources, TongueStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Tongue $resource
     * @param  \DentalSleepSolutions\Http\Requests\TongueUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Tongue $resource, TongueUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Tongue $resource
     * @param  \DentalSleepSolutions\Http\Requests\TongueDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Tongue $resource, TongueDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
