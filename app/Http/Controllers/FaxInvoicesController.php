<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\FaxInvoiceStore;
use DentalSleepSolutions\Http\Requests\FaxInvoiceUpdate;
use DentalSleepSolutions\Http\Requests\FaxInvoiceDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\FaxInvoice;
use DentalSleepSolutions\Contracts\Repositories\FaxInvoices;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class FaxInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FaxInvoices $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FaxInvoices $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FaxInvoice $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FaxInvoice $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\FaxInvoices $resources
     * @param  \DentalSleepSolutions\Http\Requests\FaxInvoiceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FaxInvoices $resources, FaxInvoiceStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\FaxInvoice $resource
     * @param  \DentalSleepSolutions\Http\Requests\FaxInvoiceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FaxInvoice $resource, FaxInvoiceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\FaxInvoice $resource
     * @param  \DentalSleepSolutions\Http\Requests\FaxInvoiceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FaxInvoice $resource, FaxInvoiceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
