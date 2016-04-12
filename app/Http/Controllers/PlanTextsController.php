<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PlanTextStore;
use DentalSleepSolutions\Http\Requests\PlanTextUpdate;
use DentalSleepSolutions\Http\Requests\PlanTextDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\PlanText;
use DentalSleepSolutions\Contracts\Repositories\PlanTexts;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PlanTextsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PlanTexts $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PlanTexts $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PlanText $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PlanText $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PlanTexts $resources
     * @param  \DentalSleepSolutions\Http\Requests\PlanTextStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PlanTexts $resources, PlanTextStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\PlanText $resource
     * @param  \DentalSleepSolutions\Http\Requests\PlanTextUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PlanText $resource, PlanTextUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PlanText $resource
     * @param  \DentalSleepSolutions\Http\Requests\PlanTextDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PlanText $resource, PlanTextDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
