<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\EpworthHomeSleepTestStore;
use DentalSleepSolutions\Http\Requests\EpworthHomeSleepTestUpdate;
use DentalSleepSolutions\Http\Requests\EpworthHomeSleepTestDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\EpworthHomeSleepTest;
use DentalSleepSolutions\Contracts\Repositories\EpworthHomeSleepTests;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class EpworthHomeSleepTestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\EpworthHomeSleepTests $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(EpworthHomeSleepTests $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\EpworthHomeSleepTest $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(EpworthHomeSleepTest $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\EpworthHomeSleepTests $resources
     * @param  \DentalSleepSolutions\Http\Requests\EpworthHomeSleepTestStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EpworthHomeSleepTests $resources, EpworthHomeSleepTestStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\EpworthHomeSleepTest $resource
     * @param  \DentalSleepSolutions\Http\Requests\EpworthHomeSleepTestUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EpworthHomeSleepTest $resource, EpworthHomeSleepTestUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\EpworthHomeSleepTest $resource
     * @param  \DentalSleepSolutions\Http\Requests\EpworthHomeSleepTestDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EpworthHomeSleepTest $resource, EpworthHomeSleepTestDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
