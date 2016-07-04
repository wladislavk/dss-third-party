<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PatientInsuranceStore;
use DentalSleepSolutions\Http\Requests\PatientInsuranceUpdate;
use DentalSleepSolutions\Http\Requests\PatientInsuranceDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\PatientInsurance;
use DentalSleepSolutions\Contracts\Repositories\PatientInsurances;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PatientInsurancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PatientInsurances $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PatientInsurances $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PatientInsurance $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PatientInsurance $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PatientInsurances $resources
     * @param  \DentalSleepSolutions\Http\Requests\PatientInsuranceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PatientInsurances $resources, PatientInsuranceStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PatientInsurance $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientInsuranceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PatientInsurance $resource, PatientInsuranceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PatientInsurance $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientInsuranceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PatientInsurance $resource, PatientInsuranceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getCurrent(PatientInsurances $resources, Request $request)
    {
        $patientId = $request->input('patientId') ?: 0;
        $docId     = $this->currentUser->docid ?: 0;

        $data = $resources->getCurrent($docId, $patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getNumber(PatientInsurances $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }
}
