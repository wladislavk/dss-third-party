<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\JointStore;
use DentalSleepSolutions\Http\Requests\JointUpdate;
use DentalSleepSolutions\Http\Requests\JointDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Joint;
use DentalSleepSolutions\Contracts\Repositories\Joints;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class JointsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Joints $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Joints $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Joint $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Joint $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Joints $resources
     * @param  \DentalSleepSolutions\Http\Requests\JointStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Joints $resources, JointStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Joint $resource
     * @param  \DentalSleepSolutions\Http\Requests\JointUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Joint $resource, JointUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Joint $resource
     * @param  \DentalSleepSolutions\Http\Requests\JointDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Joint $resource, JointDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
