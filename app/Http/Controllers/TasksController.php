<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\TaskStore;
use DentalSleepSolutions\Http\Requests\TaskUpdate;
use DentalSleepSolutions\Http\Requests\TaskDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Task;
use DentalSleepSolutions\Contracts\Repositories\Tasks;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Tasks $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Tasks $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Task $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Tasks $resources
     * @param  \DentalSleepSolutions\Http\Requests\TaskStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Tasks $resources, TaskStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Task $resource
     * @param  \DentalSleepSolutions\Http\Requests\TaskUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Task $resource, TaskUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Task $resource
     * @param  \DentalSleepSolutions\Http\Requests\TaskDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $resource, TaskDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
