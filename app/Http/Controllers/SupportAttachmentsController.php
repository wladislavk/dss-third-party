<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SupportAttachmentStore;
use DentalSleepSolutions\Http\Requests\SupportAttachmentUpdate;
use DentalSleepSolutions\Http\Requests\SupportAttachmentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\SupportAttachment;
use DentalSleepSolutions\Contracts\Repositories\SupportAttachments;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SupportAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SupportAttachments $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SupportAttachments $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportAttachment $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SupportAttachment $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SupportAttachments $resources
     * @param  \DentalSleepSolutions\Http\Requests\SupportAttachmentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SupportAttachments $resources, SupportAttachmentStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportAttachment $resource
     * @param  \DentalSleepSolutions\Http\Requests\SupportAttachmentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SupportAttachment $resource, SupportAttachmentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportAttachment $resource
     * @param  \DentalSleepSolutions\Http\Requests\SupportAttachmentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SupportAttachment $resource, SupportAttachmentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
