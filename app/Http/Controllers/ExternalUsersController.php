<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ExternalUserStore;
use DentalSleepSolutions\Http\Requests\ExternalUserUpdate;
use DentalSleepSolutions\Http\Requests\ExternalUserDestroy;
use DentalSleepSolutions\Contracts\Repositories\ExternalUsers;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ExternalUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalUsers $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ExternalUsers $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalUsers $resources
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ExternalUsers $resources, $id)
    {
        $resource = $resources->where('user_id', $id)->firstOrFail();
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalUsers $resources
     * @param  \DentalSleepSolutions\Http\Requests\ExternalUserStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ExternalUsers $resources, ExternalUserStore $request)
    {
        $data = $request->all();
        $data['created_by'] = $this->currentAdmin->id;

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalUsers $resources
     * @param int $id
     * @param  \DentalSleepSolutions\Http\Requests\ExternalUserUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ExternalUsers $resources, $id, ExternalUserUpdate $request)
    {
        $resource = $resources->where('user_id', $id)->firstOrFail();

        $data = $request->all();
        $data['updated_by'] = $this->currentAdmin->id;

        $resource->update($data);

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ExternalUsers $resources
     * @param  int $id
     * @param  \DentalSleepSolutions\Http\Requests\ExternalUserDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ExternalUsers $resources, $id, ExternalUserDestroy $request)
    {
        $resource = $resources->where('user_id', $id)->firstOrFail();
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
