<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\UvulaStore;
use DentalSleepSolutions\Http\Requests\UvulaUpdate;
use DentalSleepSolutions\Http\Requests\UvulaDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Uvula;
use DentalSleepSolutions\Contracts\Repositories\Uvulas;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class UvulasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Uvulas $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Uvulas $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Uvula $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Uvula $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Uvulas $resources
     * @param  \DentalSleepSolutions\Http\Requests\UvulaStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Uvulas $resources, UvulaStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Uvula $resource
     * @param  \DentalSleepSolutions\Http\Requests\UvulaUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Uvula $resource, UvulaUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Uvula $resource
     * @param  \DentalSleepSolutions\Http\Requests\UvulaDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Uvula $resource, UvulaDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
