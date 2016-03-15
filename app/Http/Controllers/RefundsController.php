<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\RefundStore;
use DentalSleepSolutions\Http\Requests\RefundUpdate;
use DentalSleepSolutions\Http\Requests\RefundDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Refund;
use DentalSleepSolutions\Contracts\Repositories\Refunds;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class RefundsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Refunds $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Refunds $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Refund $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Refund $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Refunds $resources
     * @param  \DentalSleepSolutions\Http\Requests\RefundStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Refunds $resources, RefundStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Refund $resource
     * @param  \DentalSleepSolutions\Http\Requests\RefundUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Refund $resource, RefundUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Refund $resource
     * @param  \DentalSleepSolutions\Http\Requests\RefundDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Refund $resource, RefundDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
