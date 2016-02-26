<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\MedicamentStore;
use DentalSleepSolutions\Http\Requests\MedicamentUpdate;
use DentalSleepSolutions\Http\Requests\MedicamentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Medicament;
use DentalSleepSolutions\Contracts\Repositories\Medications;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class MedicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Medications $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Medications $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Medicament $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Medicament $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Medications $resources
     * @param  \DentalSleepSolutions\Http\Requests\MedicamentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Medications $resources, MedicamentStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Medicament $resource
     * @param  \DentalSleepSolutions\Http\Requests\MedicamentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Medicament $resource, MedicamentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Medicament $resource
     * @param  \DentalSleepSolutions\Http\Requests\MedicamentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Medicament $resource, MedicamentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
