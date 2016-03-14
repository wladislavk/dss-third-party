<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\QualifierStore;
use DentalSleepSolutions\Http\Requests\QualifierUpdate;
use DentalSleepSolutions\Http\Requests\QualifierDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Qualifier;
use DentalSleepSolutions\Contracts\Repositories\Qualifiers;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class QualifiersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Qualifiers $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Qualifiers $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Qualifier $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Qualifier $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Qualifiers $resources
     * @param  \DentalSleepSolutions\Http\Requests\QualifierStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Qualifiers $resources, QualifierStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Qualifier $resource
     * @param  \DentalSleepSolutions\Http\Requests\QualifierUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Qualifier $resource, QualifierUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Qualifier $resource
     * @param  \DentalSleepSolutions\Http\Requests\QualifierDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Qualifier $resource, QualifierDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
