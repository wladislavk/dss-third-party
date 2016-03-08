<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ProfileImageStore;
use DentalSleepSolutions\Http\Requests\ProfileImageUpdate;
use DentalSleepSolutions\Http\Requests\ProfileImageDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ProfileImage;
use DentalSleepSolutions\Contracts\Repositories\ProfileImages;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ProfileImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ProfileImages $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProfileImages $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ProfileImage $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ProfileImage $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ProfileImages $resources
     * @param  \DentalSleepSolutions\Http\Requests\ProfileImageStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProfileImages $resources, ProfileImageStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ProfileImage $resource
     * @param  \DentalSleepSolutions\Http\Requests\ProfileImageUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProfileImage $resource, ProfileImageUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ProfileImage $resource
     * @param  \DentalSleepSolutions\Http\Requests\ProfileImageDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ProfileImage $resource, ProfileImageDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
