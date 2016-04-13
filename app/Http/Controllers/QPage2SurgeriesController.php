<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\QPage2SurgeryStore;
use DentalSleepSolutions\Http\Requests\QPage2SurgeryUpdate;
use DentalSleepSolutions\Http\Requests\QPage2SurgeryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\QPage2Surgery;
use DentalSleepSolutions\Contracts\Repositories\QPage2Surgeries;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class QPage2SurgeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\QPage2Surgeries $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(QPage2Surgeries $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\QPage2Surgery $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(QPage2Surgery $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\QPage2Surgeries $resources
     * @param  \DentalSleepSolutions\Http\Requests\QPage2SurgeryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(QPage2Surgeries $resources, QPage2SurgeryStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\QPage2Surgery $resource
     * @param  \DentalSleepSolutions\Http\Requests\QPage2SurgeryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(QPage2Surgery $resource, QPage2SurgeryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\QPage2Surgery $resource
     * @param  \DentalSleepSolutions\Http\Requests\QPage2SurgeryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(QPage2Surgery $resource, QPage2SurgeryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
