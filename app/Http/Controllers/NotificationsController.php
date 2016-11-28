<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\NotificationStore;
use DentalSleepSolutions\Http\Requests\NotificationUpdate;
use DentalSleepSolutions\Http\Requests\NotificationDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Notification;
use DentalSleepSolutions\Contracts\Repositories\Notifications;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Notifications $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Notifications $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Notification $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Notification $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Notifications $resources
     * @param  \DentalSleepSolutions\Http\Requests\NotificationStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Notifications $resources, NotificationStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Notification $resource
     * @param  \DentalSleepSolutions\Http\Requests\NotificationUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Notification $resource, NotificationUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Notification $resource
     * @param  \DentalSleepSolutions\Http\Requests\NotificationDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Notification $resource, NotificationDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
