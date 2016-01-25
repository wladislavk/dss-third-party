<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\AccessCodeStore;
use DentalSleepSolutions\Http\Requests\AccessCodeUpdate;
use DentalSleepSolutions\Http\Requests\AccessCodeDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\AccessCode;
use DentalSleepSolutions\Contracts\Repositories\AccessCodes;
use Carbon\Carbon;

class AccessCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\AccessCodes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AccessCodes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\AccessCode $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AccessCode $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\AccessCodes $resources
     * @param  \DentalSleepSolutions\Http\Requests\AccessCodeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AccessCodes $resources, AccessCodeStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\AccessCode $resource
     * @param  \DentalSleepSolutions\Http\Requests\AccessCodeUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccessCode $resource, AccessCodeUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\AccessCode $resource
     * @param  \DentalSleepSolutions\Http\Requests\AccessCodeDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AccessCode $resource, AccessCodeDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
