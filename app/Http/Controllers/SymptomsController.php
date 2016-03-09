<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SymptomStore;
use DentalSleepSolutions\Http\Requests\SymptomUpdate;
use DentalSleepSolutions\Http\Requests\SymptomDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Symptom;
use DentalSleepSolutions\Contracts\Repositories\Symptoms;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SymptomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Symptoms $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Symptoms $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Symptom $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Symptom $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Symptoms $resources
     * @param  \DentalSleepSolutions\Http\Requests\SymptomStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Symptoms $resources, SymptomStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Symptom $resource
     * @param  \DentalSleepSolutions\Http\Requests\SymptomUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Symptom $resource, SymptomUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Symptom $resource
     * @param  \DentalSleepSolutions\Http\Requests\SymptomDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Symptom $resource, SymptomDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
