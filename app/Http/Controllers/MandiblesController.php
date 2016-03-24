<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\MandibleStore;
use DentalSleepSolutions\Http\Requests\MandibleUpdate;
use DentalSleepSolutions\Http\Requests\MandibleDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Mandible;
use DentalSleepSolutions\Contracts\Repositories\Mandibles;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class MandiblesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Mandibles $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Mandibles $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Mandible $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Mandible $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Mandibles $resources
     * @param  \DentalSleepSolutions\Http\Requests\MandibleStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Mandibles $resources, MandibleStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Mandible $resource
     * @param  \DentalSleepSolutions\Http\Requests\MandibleUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Mandible $resource, MandibleUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Mandible $resource
     * @param  \DentalSleepSolutions\Http\Requests\MandibleDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Mandible $resource, MandibleDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
