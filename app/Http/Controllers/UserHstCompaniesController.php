<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\UserHstCompanyStore;
use DentalSleepSolutions\Http\Requests\UserHstCompanyUpdate;
use DentalSleepSolutions\Http\Requests\UserHstCompanyDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\UserHstCompany;
use DentalSleepSolutions\Contracts\Repositories\UserHstCompanies;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class UserHstCompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\UserHstCompanies $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserHstCompanies $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\UserHstCompany $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UserHstCompany $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\UserHstCompanies $resources
     * @param  \DentalSleepSolutions\Http\Requests\UserHstCompanyStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserHstCompanies $resources, UserHstCompanyStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\UserHstCompany $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserHstCompanyUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserHstCompany $resource, UserHstCompanyUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\UserHstCompany $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserHstCompanyDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(UserHstCompany $resource, UserHstCompanyDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
