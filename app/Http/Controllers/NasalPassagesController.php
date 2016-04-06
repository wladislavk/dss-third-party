<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\NasalPassageStore;
use DentalSleepSolutions\Http\Requests\NasalPassageUpdate;
use DentalSleepSolutions\Http\Requests\NasalPassageDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\NasalPassage;
use DentalSleepSolutions\Contracts\Repositories\NasalPassages;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class NasalPassagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\NasalPassages $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(NasalPassages $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\NasalPassage $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(NasalPassage $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\NasalPassages $resources
     * @param  \DentalSleepSolutions\Http\Requests\NasalPassageStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NasalPassages $resources, NasalPassageStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\NasalPassage $resource
     * @param  \DentalSleepSolutions\Http\Requests\NasalPassageUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NasalPassage $resource, NasalPassageUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\NasalPassage $resource
     * @param  \DentalSleepSolutions\Http\Requests\NasalPassageDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(NasalPassage $resource, NasalPassageDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
