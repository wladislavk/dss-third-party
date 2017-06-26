<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\ExternalCompanyStore;
use DentalSleepSolutions\Http\Requests\ExternalCompanyUpdate;
use DentalSleepSolutions\Http\Requests\ExternalCompanyDestroy;
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
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalCompanies $resources
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
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalCompanies $resources
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ExternalCompanies $resources, $id)
    {
        $resource = $resources-findOrFail($id);
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalCompanies $resources
     * @param  \DentalSleepSolutions\Http\Requests\ExternalCompanyStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ExternalCompanies $resources, ExternalCompanyStore $request)
    {
        $data = $request->all();
        /**
         * @ToDo: Handle admin tokens
         * @see AWS-19-Request-Token
         */
        $data['created_by'] = $this->currentUser->id;

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalCompanies $resources
     * @param int $id
     * @param  \DentalSleepSolutions\Http\Requests\ExternalCompanyUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ExternalCompanies $resources, $id, ExternalCompanyUpdate $request)
    {
        $resource = $resources->findOrFail($id);

        $data = $request->all();
        /**
         * @ToDo: Handle admin tokens
         * @see AWS-19-Request-Token
         */
        $data['updated_by'] = $this->currentUser->id;

        $resource->update($data);

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalCompanies $resources
     * @param  int $id
     * @param  \DentalSleepSolutions\Http\Requests\ExternalCompanyDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ExternalCompanies $resources, $id, ExternalCompanyDestroy $request)
    {
        $resource = $resources->findOrFail($id);
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
