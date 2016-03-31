<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\TransactionCodeStore;
use DentalSleepSolutions\Http\Requests\TransactionCodeUpdate;
use DentalSleepSolutions\Http\Requests\TransactionCodeDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\TransactionCode;
use DentalSleepSolutions\Contracts\Repositories\TransactionCodes;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class TransactionCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TransactionCodes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TransactionCodes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TransactionCode $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TransactionCode $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TransactionCodes $resources
     * @param  \DentalSleepSolutions\Http\Requests\TransactionCodeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TransactionCodes $resources, TransactionCodeStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\TransactionCode $resource
     * @param  \DentalSleepSolutions\Http\Requests\TransactionCodeUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TransactionCode $resource, TransactionCodeUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TransactionCode $resource
     * @param  \DentalSleepSolutions\Http\Requests\TransactionCodeDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TransactionCode $resource, TransactionCodeDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
