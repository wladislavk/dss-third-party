<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\AppointmentTypeStore;
use DentalSleepSolutions\Http\Requests\AppointmentTypeUpdate;
use DentalSleepSolutions\Http\Requests\AppointmentTypeDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\AppointmentType;
use DentalSleepSolutions\Contracts\Repositories\AppointmentTypes;
use Carbon\Carbon;

class AppointmentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\AppointmentTypes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AppointmentTypes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\AppointmentType $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AppointmentType $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\AppointmentTypes $resources
     * @param  \DentalSleepSolutions\Http\Requests\AppointmentTypeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AppointmentTypes $resources, AppointmentTypeStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\AppointmentType $resource
     * @param  \DentalSleepSolutions\Http\Requests\AppointmentTypeUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AppointmentType $resource, AppointmentTypeUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\AppointmentType $resource
     * @param  \DentalSleepSolutions\Http\Requests\AppointmentTypeDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AppointmentType $resource, AppointmentTypeDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
