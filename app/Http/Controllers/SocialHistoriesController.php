<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SocialHistoryStore;
use DentalSleepSolutions\Http\Requests\SocialHistoryUpdate;
use DentalSleepSolutions\Http\Requests\SocialHistoryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\SocialHistory;
use DentalSleepSolutions\Contracts\Repositories\SocialHistories;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SocialHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SocialHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SocialHistories $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SocialHistory $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SocialHistory $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\SocialHistories $resources
     * @param  \DentalSleepSolutions\Http\Requests\SocialHistoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SocialHistories $resources, SocialHistoryStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\SocialHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\SocialHistoryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SocialHistory $resource, SocialHistoryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\SocialHistory $resource
     * @param  \DentalSleepSolutions\Http\Requests\SocialHistoryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SocialHistory $resource, SocialHistoryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
