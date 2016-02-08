<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\MedicalHistoryStore;
use DentalSleepSolutions\Http\Requests\MedicalHistoryUpdate;
use DentalSleepSolutions\Http\Requests\MedicalHistoryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\MedicalHistory;
use DentalSleepSolutions\Contracts\Repositories\MedicalHistories;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class MedicalHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\MedicalHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(MedicalHistories $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\MedicalHistory $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MedicalHistory $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\MedicalHistories $resources
     * @param  \DentalSleepSolutions\Http\Requests\MedicalHistoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MedicalHistories $resources, MedicalHistoryStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\MedicalHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\MedicalHistoryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MedicalHistory $resource, MedicalHistoryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\MedicalHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\MedicalHistoryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MedicalHistory $resource, MedicalHistoryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
