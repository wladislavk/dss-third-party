<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsurancePayerStore;
use DentalSleepSolutions\Http\Requests\InsurancePayerUpdate;
use DentalSleepSolutions\Http\Requests\InsurancePayerDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\InsurancePayer;
use DentalSleepSolutions\Contracts\Repositories\InsurancePayers;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class InsurancePayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsurancePayers $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InsurancePayers $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsurancePayer $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(InsurancePayer $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsurancePayers $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsurancePayerStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InsurancePayers $resources, InsurancePayerStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\InsurancePayer $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsurancePayerUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InsurancePayer $resource, InsurancePayerUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsurancePayer $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsurancePayerDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InsurancePayer $resource, InsurancePayerDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
