<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SupportTicketStore;
use DentalSleepSolutions\Http\Requests\SupportTicketUpdate;
use DentalSleepSolutions\Http\Requests\SupportTicketDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\SupportTicket;
use DentalSleepSolutions\Contracts\Repositories\SupportTickets;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SupportTicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SupportTickets $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SupportTickets $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportTicket $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SupportTicket $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SupportTickets $resources
     * @param  \DentalSleepSolutions\Http\Requests\SupportTicketStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SupportTickets $resources, SupportTicketStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportTicket $resource
     * @param  \DentalSleepSolutions\Http\Requests\SupportTicketUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SupportTicket $resource, SupportTicketUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SupportTicket $resource
     * @param  \DentalSleepSolutions\Http\Requests\SupportTicketDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SupportTicket $resource, SupportTicketDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getNumber(SupportTickets $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }
}
