<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ClaimTextStore;
use DentalSleepSolutions\Http\Requests\ClaimTextUpdate;
use DentalSleepSolutions\Http\Requests\ClaimTextDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ClaimText;
use DentalSleepSolutions\Contracts\Repositories\ClaimTexts;
use Carbon\Carbon;

class ClaimTextsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ClaimTexts $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ClaimTexts $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimText $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ClaimText $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ClaimTexts $resources
     * @param  \DentalSleepSolutions\Http\Requests\ClaimTextStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClaimTexts $resources, ClaimTextStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimText $resource
     * @param  \DentalSleepSolutions\Http\Requests\ClaimTextUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClaimText $resource, ClaimTextUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimText $resource
     * @param  \DentalSleepSolutions\Http\Requests\ClaimTextDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ClaimText $resource, ClaimTextDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
