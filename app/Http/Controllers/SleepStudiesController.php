<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SleepStudyStore;
use DentalSleepSolutions\Http\Requests\SleepStudyUpdate;
use DentalSleepSolutions\Http\Requests\SleepStudyDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\SleepStudy;
use DentalSleepSolutions\Contracts\Repositories\SleepStudies;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SleepStudiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SleepStudies $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SleepStudies $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SleepStudy $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SleepStudy $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SleepStudies $resources
     * @param  \DentalSleepSolutions\Http\Requests\SleepStudyStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SleepStudies $resources, SleepStudyStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SleepStudy $resource
     * @param  \DentalSleepSolutions\Http\Requests\SleepStudyUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SleepStudy $resource, SleepStudyUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SleepStudy $resource
     * @param  \DentalSleepSolutions\Http\Requests\SleepStudyDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SleepStudy $resource, SleepStudyDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
