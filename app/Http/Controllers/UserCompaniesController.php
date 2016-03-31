<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\UserCompanyStore;
use DentalSleepSolutions\Http\Requests\UserCompanyUpdate;
use DentalSleepSolutions\Http\Requests\UserCompanyDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\UserCompany;
use DentalSleepSolutions\Contracts\Repositories\UserCompanies;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class UserCompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\UserCompanies $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserCompanies $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\UserCompany $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UserCompany $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\UserCompanies $resources
     * @param  \DentalSleepSolutions\Http\Requests\UserCompanyStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserCompanies $resources, UserCompanyStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\UserCompany $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserCompanyUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserCompany $resource, UserCompanyUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\UserCompany $resource
     * @param  \DentalSleepSolutions\Http\Requests\UserCompanyDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(UserCompany $resource, UserCompanyDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
