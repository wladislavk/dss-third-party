<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ExtraPercaseInvoiceStore;
use DentalSleepSolutions\Http\Requests\ExtraPercaseInvoiceUpdate;
use DentalSleepSolutions\Http\Requests\ExtraPercaseInvoiceDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ExtraPercaseInvoice;
use DentalSleepSolutions\Contracts\Repositories\ExtraPercaseInvoices;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ExtraPercaseInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExtraPercaseInvoices $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ExtraPercaseInvoices $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ExtraPercaseInvoice $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ExtraPercaseInvoice $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExtraPercaseInvoices $resources
     * @param  \DentalSleepSolutions\Http\Requests\ExtraPercaseInvoiceStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ExtraPercaseInvoices $resources, ExtraPercaseInvoiceStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ExtraPercaseInvoice $resource
     * @param  \DentalSleepSolutions\Http\Requests\ExtraPercaseInvoiceUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ExtraPercaseInvoice $resource, ExtraPercaseInvoiceUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ExtraPercaseInvoice $resource
     * @param  \DentalSleepSolutions\Http\Requests\ExtraPercaseInvoiceDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ExtraPercaseInvoice $resource, ExtraPercaseInvoiceDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
