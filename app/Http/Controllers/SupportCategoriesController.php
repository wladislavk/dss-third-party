<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SupportCategoryStore;
use DentalSleepSolutions\Http\Requests\SupportCategoryUpdate;
use DentalSleepSolutions\Http\Requests\SupportCategoryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\SupportCategory;
use DentalSleepSolutions\Contracts\Repositories\SupportCategories;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SupportCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SupportCategories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SupportCategories $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportCategory $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SupportCategory $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SupportCategories $resources
     * @param  \DentalSleepSolutions\Http\Requests\SupportCategoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SupportCategories $resources, SupportCategoryStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportCategory $resource
     * @param  \DentalSleepSolutions\Http\Requests\SupportCategoryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SupportCategory $resource, SupportCategoryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportCategory $resource
     * @param  \DentalSleepSolutions\Http\Requests\SupportCategoryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SupportCategory $resource, SupportCategoryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
