<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PatientContactStore;
use DentalSleepSolutions\Http\Requests\PatientContactUpdate;
use DentalSleepSolutions\Http\Requests\PatientContactDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\PatientContact;
use DentalSleepSolutions\Contracts\Repositories\PatientContacts;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PatientContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PatientContacts $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PatientContacts $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PatientContact $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PatientContact $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PatientContacts $resources
     * @param  \DentalSleepSolutions\Http\Requests\PatientContactStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PatientContacts $resources, PatientContactStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\PatientContact $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientContactUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PatientContact $resource, PatientContactUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PatientContact $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientContactDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PatientContact $resource, PatientContactDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getCurrent(PatientContacts $resources, Request $request)
    {
        $patientId = $request->input('patientId') ?: 0;
        $docId     = $this->currentUser->docid ?: 0;

        $data = $resources->getCurrent($docId, $patientId);

        return ApiResponse::responseOk('', $data);
    }
}
