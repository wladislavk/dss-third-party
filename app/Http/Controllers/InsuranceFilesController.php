<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsuranceFileStore;
use DentalSleepSolutions\Http\Requests\InsuranceFileUpdate;
use DentalSleepSolutions\Http\Requests\InsuranceFileDestroy;
use DentalSleepSolutions\Contracts\Resources\InsuranceFile;
use DentalSleepSolutions\Contracts\Repositories\InsuranceFiles;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class InsuranceFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceFiles $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InsuranceFiles $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceFile $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(InsuranceFile $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceFiles $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceFileStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InsuranceFiles $resources, InsuranceFileStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceFile $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceFileUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InsuranceFile $resource, InsuranceFileUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceFile $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceFileDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InsuranceFile $resource, InsuranceFileDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
