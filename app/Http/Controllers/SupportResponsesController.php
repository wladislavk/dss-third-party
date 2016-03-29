<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SupportResponseStore;
use DentalSleepSolutions\Http\Requests\SupportResponseUpdate;
use DentalSleepSolutions\Http\Requests\SupportResponseDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\SupportResponse;
use DentalSleepSolutions\Contracts\Repositories\SupportResponses;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SupportResponsesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SupportResponses $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SupportResponses $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportResponse $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SupportResponse $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SupportResponses $resources
     * @param  \DentalSleepSolutions\Http\Requests\SupportResponseStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SupportResponses $resources, SupportResponseStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportResponse $resource
     * @param  \DentalSleepSolutions\Http\Requests\SupportResponseUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SupportResponse $resource, SupportResponseUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportResponse $resource
     * @param  \DentalSleepSolutions\Http\Requests\SupportResponseDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SupportResponse $resource, SupportResponseDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
