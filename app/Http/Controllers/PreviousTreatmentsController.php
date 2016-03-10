<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PreviousTreatmentStore;
use DentalSleepSolutions\Http\Requests\PreviousTreatmentUpdate;
use DentalSleepSolutions\Http\Requests\PreviousTreatmentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\PreviousTreatment;
use DentalSleepSolutions\Contracts\Repositories\PreviousTreatments;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PreviousTreatmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PreviousTreatments $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PreviousTreatments $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PreviousTreatment $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PreviousTreatment $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PreviousTreatments $resources
     * @param  \DentalSleepSolutions\Http\Requests\PreviousTreatmentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PreviousTreatments $resources, PreviousTreatmentStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\PreviousTreatment $resource
     * @param  \DentalSleepSolutions\Http\Requests\PreviousTreatmentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PreviousTreatment $resource, PreviousTreatmentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PreviousTreatment $resource
     * @param  \DentalSleepSolutions\Http\Requests\PreviousTreatmentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PreviousTreatment $resource, PreviousTreatmentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
