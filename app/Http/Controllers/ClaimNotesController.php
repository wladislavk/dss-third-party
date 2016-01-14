<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ClaimNoteStore;
use DentalSleepSolutions\Http\Requests\ClaimNoteUpdate;
use DentalSleepSolutions\Http\Requests\ClaimNoteDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ClaimNote;
use DentalSleepSolutions\Contracts\Repositories\ClaimNotes;
use Carbon\Carbon;

class ClaimNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ClaimNotes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ClaimNotes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimNote $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ClaimNote $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ClaimNotes $resources
     * @param  \DentalSleepSolutions\Http\Requests\ClaimNoteStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClaimNotes $resources, ClaimNoteStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimNote $resource
     * @param  \DentalSleepSolutions\Http\Requests\ClaimNoteUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClaimNote $resource, ClaimNoteUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimNote $resource
     * @param  \DentalSleepSolutions\Http\Requests\ClaimNoteDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ClaimNote $resource, ClaimNoteDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
