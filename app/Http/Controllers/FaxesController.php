<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\FaxStore;
use DentalSleepSolutions\Http\Requests\FaxUpdate;
use DentalSleepSolutions\Http\Requests\FaxDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Fax;
use DentalSleepSolutions\Contracts\Repositories\Faxes;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class FaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Faxes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Faxes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Fax $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Fax $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Faxes $resources
     * @param  \DentalSleepSolutions\Http\Requests\FaxStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Faxes $resources, FaxStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Fax $resource
     * @param  \DentalSleepSolutions\Http\Requests\FaxUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Fax $resource, FaxUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Fax $resource
     * @param  \DentalSleepSolutions\Http\Requests\FaxDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Fax $resource, FaxDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
