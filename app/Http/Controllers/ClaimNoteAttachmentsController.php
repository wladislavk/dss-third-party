<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ClaimNoteAttachmentStore;
use DentalSleepSolutions\Http\Requests\ClaimNoteAttachmentUpdate;
use DentalSleepSolutions\Http\Requests\ClaimNoteAttachmentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ClaimNoteAttachment;
use DentalSleepSolutions\Contracts\Repositories\ClaimNoteAttachments;
use Carbon\Carbon;

class ClaimNoteAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ClaimNoteAttachments $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ClaimNoteAttachments $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimNoteAttachment $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ClaimNoteAttachment $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ClaimNoteAttachments $resources
     * @param  \DentalSleepSolutions\Http\Requests\ClaimNoteAttachmentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClaimNoteAttachments $resources, ClaimNoteAttachmentStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimNoteAttachment $resource
     * @param  \DentalSleepSolutions\Http\Requests\ClaimNoteAttachmentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClaimNoteAttachment $resource, ClaimNoteAttachmentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ClaimNoteAttachment $resource
     * @param  \DentalSleepSolutions\Http\Requests\ClaimNoteAttachmentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ClaimNoteAttachment $resource, ClaimNoteAttachmentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
