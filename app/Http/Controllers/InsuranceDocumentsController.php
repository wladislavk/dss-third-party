<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\InsuranceDocumentStore;
use DentalSleepSolutions\Http\Requests\InsuranceDocumentUpdate;
use DentalSleepSolutions\Http\Requests\InsuranceDocumentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\InsuranceDocument;
use DentalSleepSolutions\Contracts\Repositories\InsuranceDocuments;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class InsuranceDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceDocuments $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InsuranceDocuments $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceDocument $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(InsuranceDocument $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\InsuranceDocuments $resources
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceDocumentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InsuranceDocuments $resources, InsuranceDocumentStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceDocument $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceDocumentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InsuranceDocument $resource, InsuranceDocumentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\InsuranceDocument $resource
     * @param  \DentalSleepSolutions\Http\Requests\InsuranceDocumentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InsuranceDocument $resource, InsuranceDocumentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
