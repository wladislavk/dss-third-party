<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ChangeListStore;
use DentalSleepSolutions\Http\Requests\ChangeListUpdate;
use DentalSleepSolutions\Http\Requests\ChangeListDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ChangeList;
use DentalSleepSolutions\Contracts\Repositories\ChangeLists;
use Carbon\Carbon;

class ChangeListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ChangeLists $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ChangeLists $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ChangeList $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ChangeList $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ChangeLists $resources
     * @param  \DentalSleepSolutions\Http\Requests\ChangeListStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ChangeLists $resources, ChangeListStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ChangeList $resource
     * @param  \DentalSleepSolutions\Http\Requests\ChangeListUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ChangeList $resource, ChangeListUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ChangeList $resource
     * @param  \DentalSleepSolutions\Http\Requests\ChangeListDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ChangeList $resource, ChangeListDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
