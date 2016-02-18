<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LedgerNoteStore;
use DentalSleepSolutions\Http\Requests\LedgerNoteUpdate;
use DentalSleepSolutions\Http\Requests\LedgerNoteDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\LedgerNote;
use DentalSleepSolutions\Contracts\Repositories\LedgerNotes;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LedgerNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerNotes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LedgerNotes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerNote $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LedgerNote $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LedgerNotes $resources
     * @param  \DentalSleepSolutions\Http\Requests\LedgerNoteStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LedgerNotes $resources, LedgerNoteStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerNote $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerNoteUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LedgerNote $resource, LedgerNoteUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LedgerNote $resource
     * @param  \DentalSleepSolutions\Http\Requests\LedgerNoteDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LedgerNote $resource, LedgerNoteDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
