<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ScreenerStore;
use DentalSleepSolutions\Http\Requests\ScreenerUpdate;
use DentalSleepSolutions\Http\Requests\ScreenerDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Screener;
use DentalSleepSolutions\Contracts\Repositories\Screeners;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ScreenersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Screeners $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Screeners $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Screener $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Screener $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Screeners $resources
     * @param  \DentalSleepSolutions\Http\Requests\ScreenerStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Screeners $resources, ScreenerStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Screener $resource
     * @param  \DentalSleepSolutions\Http\Requests\ScreenerUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Screener $resource, ScreenerUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Screener $resource
     * @param  \DentalSleepSolutions\Http\Requests\ScreenerDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Screener $resource, ScreenerDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
