<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LoginDetailStore;
use DentalSleepSolutions\Http\Requests\LoginDetailUpdate;
use DentalSleepSolutions\Http\Requests\LoginDetailDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\LoginDetail;
use DentalSleepSolutions\Contracts\Repositories\LoginDetails;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LoginDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LoginDetails $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LoginDetails $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LoginDetail $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LoginDetail $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LoginDetails $resources
     * @param  \DentalSleepSolutions\Http\Requests\LoginDetailStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LoginDetails $resources, LoginDetailStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\LoginDetail $resource
     * @param  \DentalSleepSolutions\Http\Requests\LoginDetailUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LoginDetail $resource, LoginDetailUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LoginDetail $resource
     * @param  \DentalSleepSolutions\Http\Requests\LoginDetailDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LoginDetail $resource, LoginDetailDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
