<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ComplaintStore;
use DentalSleepSolutions\Http\Requests\ComplaintUpdate;
use DentalSleepSolutions\Http\Requests\ComplaintDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Complaint;
use DentalSleepSolutions\Contracts\Repositories\Complaints;
use Carbon\Carbon;

class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Complaints $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Complaints $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Complaint $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Complaint $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Complaints $resources
     * @param  \DentalSleepSolutions\Http\Requests\ComplaintStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Complaints $resources, ComplaintStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Complaint $resource
     * @param  \DentalSleepSolutions\Http\Requests\ComplaintUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Complaint $resource, ComplaintUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Complaint $resource
     * @param  \DentalSleepSolutions\Http\Requests\ComplaintDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Complaint $resource, ComplaintDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
