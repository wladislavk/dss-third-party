<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\SleeplabStore;
use DentalSleepSolutions\Http\Requests\SleeplabUpdate;
use DentalSleepSolutions\Http\Requests\SleeplabDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Sleeplab;
use DentalSleepSolutions\Contracts\Repositories\Sleeplabs;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class SleeplabsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Sleeplabs $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Sleeplabs $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Sleeplab $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Sleeplab $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Sleeplabs $resources
     * @param  \DentalSleepSolutions\Http\Requests\SleeplabStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Sleeplabs $resources, SleeplabStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Sleeplab $resource
     * @param  \DentalSleepSolutions\Http\Requests\SleeplabUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Sleeplab $resource, SleeplabUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Sleeplab $resource
     * @param  \DentalSleepSolutions\Http\Requests\SleeplabDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Sleeplab $resource, SleeplabDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getListOfSleeplabs(Sleeplabs $resources, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $page = $request->input('page') ?: 0;
        $rowsPerPage = $request->input('rows_per_page');
        $sort = $request->input('sort');
        $sortDir = $request->input('sort_dir');
        $letter = $request->input('letter');

        $sleeplabs = $resources->getList($docId, $page, $rowsPerPage, $sort, $sortDir, $letter);

        return ApiResponse::responseOk('', $sleeplabs);
    }
}
