<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\CompanyStore;
use DentalSleepSolutions\Http\Requests\CompanyUpdate;
use DentalSleepSolutions\Http\Requests\CompanyDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Company;
use DentalSleepSolutions\Contracts\Repositories\Companies;
use Carbon\Carbon;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Companies $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Companies $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Company $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Company $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Companies $resources
     * @param  \DentalSleepSolutions\Http\Requests\CompanyStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Companies $resources, CompanyStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Company $resource
     * @param  \DentalSleepSolutions\Http\Requests\CompanyUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Company $resource, CompanyUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Company $resource
     * @param  \DentalSleepSolutions\Http\Requests\CompanyDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Company $resource, CompanyDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
