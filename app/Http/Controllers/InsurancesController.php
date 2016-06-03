<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsuranceStore;
use DentalSleepSolutions\Http\Requests\InsuranceUpdate;
use DentalSleepSolutions\Http\Requests\InsuranceDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Insurance;
use DentalSleepSolutions\Contracts\Repositories\Insurances;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class InsurancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Insurances $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Insurances $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Insurance $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Insurance $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Insurances $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Insurances $resources, InsuranceStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Insurance $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Insurance $resource, InsuranceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Insurance $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Insurance $resource, InsuranceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getRejected(Insurances $resources, Request $request)
    {
        $patientId = $request->input('patientId');

        $data = $resources->getRejected($patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getFrontOfficeClaims($type, Insurances $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        switch ($type) {
            case 'pending-claims':
                $data = $resources->getPendingClaims($docId);
                break;
            default:
                $data = [];
                break;
        }

        dd($data);

        return ApiResponse::responseOk('', $data);
    }
}
