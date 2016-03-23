<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsuranceTypeStore;
use DentalSleepSolutions\Http\Requests\InsuranceTypeUpdate;
use DentalSleepSolutions\Http\Requests\InsuranceTypeDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\InsuranceType;
use DentalSleepSolutions\Contracts\Repositories\InsuranceTypes;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class InsuranceTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceTypes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InsuranceTypes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceType $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(InsuranceType $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceTypes $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceTypeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InsuranceTypes $resources, InsuranceTypeStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceType $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceTypeUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InsuranceType $resource, InsuranceTypeUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceType $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceTypeDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InsuranceType $resource, InsuranceTypeDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
