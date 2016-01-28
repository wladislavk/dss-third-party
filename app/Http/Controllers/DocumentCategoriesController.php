<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\DocumentCategoryStore;
use DentalSleepSolutions\Http\Requests\DocumentCategoryUpdate;
use DentalSleepSolutions\Http\Requests\DocumentCategoryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\DocumentCategory;
use DentalSleepSolutions\Contracts\Repositories\DocumentCategories;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class DocumentCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\DocumentCategories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DocumentCategories $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\DocumentCategory $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DocumentCategory $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\DocumentCategories $resources
     * @param  \DentalSleepSolutions\Http\Requests\DocumentCategoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DocumentCategories $resources, DocumentCategoryStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\DocumentCategory $resource
     * @param  \DentalSleepSolutions\Http\Requests\DocumentCategoryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DocumentCategory $resource, DocumentCategoryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\DocumentCategory $resource
     * @param  \DentalSleepSolutions\Http\Requests\DocumentCategoryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DocumentCategory $resource, DocumentCategoryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
