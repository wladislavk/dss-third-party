<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ImageTypeStore;
use DentalSleepSolutions\Http\Requests\ImageTypeUpdate;
use DentalSleepSolutions\Http\Requests\ImageTypeDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ImageType;
use DentalSleepSolutions\Contracts\Repositories\ImageTypes;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ImageTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ImageTypes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ImageTypes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ImageType $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ImageType $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ImageTypes $resources
     * @param  \DentalSleepSolutions\Http\Requests\ImageTypeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageTypes $resources, ImageTypeStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ImageType $resource
     * @param  \DentalSleepSolutions\Http\Requests\ImageTypeUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ImageType $resource, ImageTypeUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ImageType $resource
     * @param  \DentalSleepSolutions\Http\Requests\ImageTypeDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ImageType $resource, ImageTypeDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
