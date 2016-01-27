<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\DocumentStore;
use DentalSleepSolutions\Http\Requests\DocumentUpdate;
use DentalSleepSolutions\Http\Requests\DocumentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Document;
use DentalSleepSolutions\Contracts\Repositories\Documents;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Documents $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Documents $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Document $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Document $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Documents $resources
     * @param  \DentalSleepSolutions\Http\Requests\DocumentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Documents $resources, DocumentStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Document $resource
     * @param  \DentalSleepSolutions\Http\Requests\DocumentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Document $resource, DocumentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Document $resource
     * @param  \DentalSleepSolutions\Http\Requests\DocumentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Document $resource, DocumentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
