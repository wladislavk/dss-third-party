<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ProcedureStore;
use DentalSleepSolutions\Http\Requests\ProcedureUpdate;
use DentalSleepSolutions\Http\Requests\ProcedureDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Procedure;
use DentalSleepSolutions\Contracts\Repositories\Procedures;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ProceduresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Procedures $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Procedures $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Procedure $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Procedure $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Procedures $resources
     * @param  \DentalSleepSolutions\Http\Requests\ProcedureStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Procedures $resources, ProcedureStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Procedure $resource
     * @param  \DentalSleepSolutions\Http\Requests\ProcedureUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Procedure $resource, ProcedureUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Procedure $resource
     * @param  \DentalSleepSolutions\Http\Requests\ProcedureDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Procedure $resource, ProcedureDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
