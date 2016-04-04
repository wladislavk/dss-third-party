<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\UserSignatureStore;
use DentalSleepSolutions\Http\Requests\UserSignatureUpdate;
use DentalSleepSolutions\Http\Requests\UserSignatureDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\UserSignature;
use DentalSleepSolutions\Contracts\Repositories\UserSignatures;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class UserSignaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\UserSignatures $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserSignatures $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\UserSignature $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UserSignature $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\UserSignatures $resources
     * @param  \DentalSleepSolutions\Http\Requests\UserSignatureStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserSignatures $resources, UserSignatureStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\UserSignature $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserSignatureUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserSignature $resource, UserSignatureUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\UserSignature $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserSignatureDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(UserSignature $resource, UserSignatureDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
