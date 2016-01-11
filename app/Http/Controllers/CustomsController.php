<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\CustomStore;
use DentalSleepSolutions\Http\Requests\CustomUpdate;
use DentalSleepSolutions\Http\Requests\CustomDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Custom;
use DentalSleepSolutions\Contracts\Repositories\Customs;
use Carbon\Carbon;

class CustomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Customs $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Customs $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Custom $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Custom $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Customs $resources
     * @param  \DentalSleepSolutions\Http\Requests\CustomStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Customs $resources, CustomStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Custom $resource
     * @param  \DentalSleepSolutions\Http\Requests\CustomUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Custom $resource, CustomUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Custom $resource
     * @param  \DentalSleepSolutions\Http\Requests\CustomDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Custom $resource, CustomDestroy $request) {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
