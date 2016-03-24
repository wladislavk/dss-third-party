<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LoginStore;
use DentalSleepSolutions\Http\Requests\LoginUpdate;
use DentalSleepSolutions\Http\Requests\LoginDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Login;
use DentalSleepSolutions\Contracts\Repositories\Logins;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LoginsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Logins $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Logins $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Login $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Login $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Logins $resources
     * @param  \DentalSleepSolutions\Http\Requests\LoginStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Logins $resources, LoginStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Login $resource
     * @param  \DentalSleepSolutions\Http\Requests\LoginUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Login $resource, LoginUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Login $resource
     * @param  \DentalSleepSolutions\Http\Requests\LoginDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Login $resource, LoginDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
