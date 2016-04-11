<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PercaseInvoiceStore;
use DentalSleepSolutions\Http\Requests\PercaseInvoiceUpdate;
use DentalSleepSolutions\Http\Requests\PercaseInvoiceDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\PercaseInvoice;
use DentalSleepSolutions\Contracts\Repositories\PercaseInvoices;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PercaseInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PercaseInvoices $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PercaseInvoices $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PercaseInvoice $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PercaseInvoice $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\PercaseInvoices $resources
     * @param  \DentalSleepSolutions\Http\Requests\PercaseInvoiceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PercaseInvoices $resources, PercaseInvoiceStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\PercaseInvoice $resource
     * @param  \DentalSleepSolutions\Http\Requests\PercaseInvoiceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PercaseInvoice $resource, PercaseInvoiceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\PercaseInvoice $resource
     * @param  \DentalSleepSolutions\Http\Requests\PercaseInvoiceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PercaseInvoice $resource, PercaseInvoiceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
