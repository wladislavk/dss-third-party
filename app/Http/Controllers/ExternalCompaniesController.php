<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ExternalCompanyStore;
use DentalSleepSolutions\Http\Requests\ExternalCompanyUpdate;
use DentalSleepSolutions\Http\Requests\ExternalCompanyDestroy;
use DentalSleepSolutions\Contracts\Resources\ExternalCompany;
use DentalSleepSolutions\Contracts\Repositories\ExternalCompanies;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ExternalCompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Chairs $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ExternalCompanies $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Chair $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ExternalCompany $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Chairs $resources
     * @param  \DentalSleepSolutions\Http\Requests\ChairStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ExternalCompanies $resources, ExternalCompanyStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Chair $resource
     * @param  \DentalSleepSolutions\Http\Requests\ChairUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ExternalCompany $resource, ExternalCompanyUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Chair $resource
     * @param  \DentalSleepSolutions\Http\Requests\ChairDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ExternalCompany $resource, ExternalCompanyDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
