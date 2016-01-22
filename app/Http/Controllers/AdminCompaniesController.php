<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\AdminCompanyStore;
use DentalSleepSolutions\Http\Requests\AdminCompanyUpdate;
use DentalSleepSolutions\Http\Requests\AdminCompanyDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\AdminCompany;
use DentalSleepSolutions\Contracts\Repositories\AdminCompanies;
use Carbon\Carbon;

class AdminCompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\AdminCompanies $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AdminCompanies $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\AdminCompany $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AdminCompany $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\AdminCompanies $resources
     * @param  \DentalSleepSolutions\Http\Requests\AdminCompanyStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminCompanies $resources, AdminCompanyStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\AdminCompany $resource
     * @param  \DentalSleepSolutions\Http\Requests\AdminCompanyUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdminCompany $resource, AdminCompanyUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\AdminCompany $resource
     * @param  \DentalSleepSolutions\Http\Requests\AdminCompanyDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AdminCompany $resource, AdminCompanyDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}