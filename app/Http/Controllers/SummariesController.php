<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SummaryStore;
use DentalSleepSolutions\Http\Requests\SummaryUpdate;
use DentalSleepSolutions\Http\Requests\SummaryDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Summary;
use DentalSleepSolutions\Contracts\Repositories\Summaries;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SummariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Summaries $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Summaries $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Summary $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Summary $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Summaries $resources
     * @param  \DentalSleepSolutions\Http\Requests\SummaryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Summaries $resources, SummaryStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Summary $resource
     * @param  \DentalSleepSolutions\Http\Requests\SummaryUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Summary $resource, SummaryUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Summary $resource
     * @param  \DentalSleepSolutions\Http\Requests\SummaryDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Summary $resource, SummaryDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
