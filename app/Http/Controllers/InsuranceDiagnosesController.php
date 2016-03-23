<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsuranceDiagnosisStore;
use DentalSleepSolutions\Http\Requests\InsuranceDiagnosisUpdate;
use DentalSleepSolutions\Http\Requests\InsuranceDiagnosisDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\InsDiagnosis;
use DentalSleepSolutions\Contracts\Repositories\InsDiagnoses;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class InsuranceDiagnosesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsDiagnoses $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InsDiagnoses $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsDiagnosis $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(InsDiagnosis $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsDiagnoses $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceDiagnosisStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InsDiagnoses $resources, InsuranceDiagnosisStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\InsDiagnosis $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceDiagnosisUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InsDiagnosis $resource, InsuranceDiagnosisUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsDiagnosis $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceDiagnosisDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InsDiagnosis $resource, InsuranceDiagnosisDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
