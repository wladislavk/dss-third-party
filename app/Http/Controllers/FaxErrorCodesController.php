<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\FaxErrorCodeStore;
use DentalSleepSolutions\Http\Requests\FaxErrorCodeUpdate;
use DentalSleepSolutions\Http\Requests\FaxErrorCodeDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\FaxErrorCode;
use DentalSleepSolutions\Contracts\Repositories\FaxErrorCodes;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class FaxErrorCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FaxErrorCodes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FaxErrorCodes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FaxErrorCode $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FaxErrorCode $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FaxErrorCodes $resources
     * @param  \DentalSleepSolutions\Http\Requests\FaxErrorCodeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FaxErrorCodes $resources, FaxErrorCodeStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\FaxErrorCode $resource
     * @param  \DentalSleepSolutions\Http\Requests\FaxErrorCodeUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FaxErrorCode $resource, FaxErrorCodeUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FaxErrorCode $resource
     * @param  \DentalSleepSolutions\Http\Requests\FaxErrorCodeDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FaxErrorCode $resource, FaxErrorCodeDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
