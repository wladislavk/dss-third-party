<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\FilemanagerStore;
use DentalSleepSolutions\Http\Requests\FilemanagerUpdate;
use DentalSleepSolutions\Http\Requests\FilemanagerDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Filemanager;
use DentalSleepSolutions\Contracts\Repositories\Filemanager as Repository;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class FilemanagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Repository $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Repository $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Filemanager $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Filemanager $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Repository $resources
     * @param  \DentalSleepSolutions\Http\Requests\FilemanagerStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Repository $resources, FilemanagerStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Filemanager $resource
     * @param  \DentalSleepSolutions\Http\Requests\FilemanagerUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Filemanager $resource, FilemanagerUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Filemanager $resource
     * @param  \DentalSleepSolutions\Http\Requests\FilemanagerDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Filemanager $resource, FilemanagerDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
