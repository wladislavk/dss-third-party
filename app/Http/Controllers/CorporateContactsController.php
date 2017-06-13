<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\CorporateContactStore;
use DentalSleepSolutions\Http\Requests\CorporateContactUpdate;
use DentalSleepSolutions\Contracts\Resources\CorporateContact;
use DentalSleepSolutions\Contracts\Repositories\CorporateContacts;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class CorporateContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\CorporateContacts $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CorporateContacts $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\CorporateContact $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CorporateContact $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\CorporateContacts $resources
     * @param  \DentalSleepSolutions\Http\Requests\CorporateContactStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CorporateContacts $resources, CorporateContactStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\CorporateContact $resource
     * @param  \DentalSleepSolutions\Http\Requests\CorporateContactUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CorporateContact $resource, CorporateContactUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * TODO: there is no class CorporateContactDestroy
     *
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\CorporateContact $resource
     * @param  \DentalSleepSolutions\Http\Requests\CorporateContactDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CorporateContact $resource, CorporateContactDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
