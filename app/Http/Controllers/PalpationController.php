<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PalpationStore;
use DentalSleepSolutions\Http\Requests\PalpationUpdate;
use DentalSleepSolutions\Http\Requests\PalpationDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Palpation;
use DentalSleepSolutions\Contracts\Repositories\Palpation as Palpations;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PalpationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Palpations $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Palpations $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Palpation $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Palpation $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Palpations $resources
     * @param  \DentalSleepSolutions\Http\Requests\PalpationStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Palpations $resources, PalpationStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Palpation $resource
     * @param  \DentalSleepSolutions\Http\Requests\PalpationUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Palpation $resource, PalpationUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Palpation $resource
     * @param  \DentalSleepSolutions\Http\Requests\PalpationDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Palpation $resource, PalpationDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
