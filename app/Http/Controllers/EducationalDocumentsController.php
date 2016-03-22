<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\EducationalDocumentStore;
use DentalSleepSolutions\Http\Requests\EducationalDocumentUpdate;
use DentalSleepSolutions\Http\Requests\EducationalDocumentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\EducationalDocument;
use DentalSleepSolutions\Contracts\Repositories\EducationalDocuments;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class EducationalDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\EducationalDocuments $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(EducationalDocuments $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\EducationalDocument $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(EducationalDocument $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\EducationalDocuments $resources
     * @param  \DentalSleepSolutions\Http\Requests\EducationalDocumentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EducationalDocuments $resources, EducationalDocumentStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\EducationalDocument $resource
     * @param  \DentalSleepSolutions\Http\Requests\EducationalDocumentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EducationalDocument $resource, EducationalDocumentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\EducationalDocument $resource
     * @param  \DentalSleepSolutions\Http\Requests\EducationalDocumentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EducationalDocument $resource, EducationalDocumentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
