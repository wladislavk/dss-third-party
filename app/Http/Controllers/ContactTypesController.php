<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ContactTypeStore;
use DentalSleepSolutions\Http\Requests\ContactTypeUpdate;
use DentalSleepSolutions\Http\Requests\ContactTypeDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ContactType;
use DentalSleepSolutions\Contracts\Repositories\ContactTypes;
use Carbon\Carbon;

class ContactTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ContactTypes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ContactTypes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ContactType $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ContactType $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ContactTypes $resources
     * @param  \DentalSleepSolutions\Http\Requests\ContactTypeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContactTypes $resources, ContactTypeStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ContactType $resource
     * @param  \DentalSleepSolutions\Http\Requests\ContactTypeUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContactType $resource, ContactTypeUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ContactType $resource
     * @param  \DentalSleepSolutions\Http\Requests\ContactTypeDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ContactType $resource, ContactTypeDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
