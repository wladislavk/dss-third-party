<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ModifierCodeStore;
use DentalSleepSolutions\Http\Requests\ModifierCodeUpdate;
use DentalSleepSolutions\Http\Requests\ModifierCodeDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\ModifierCode;
use DentalSleepSolutions\Contracts\Repositories\ModifierCodes;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class ModifierCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ModifierCodes $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ModifierCodes $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ModifierCode $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ModifierCode $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\ModifierCodes $resources
     * @param  \DentalSleepSolutions\Http\Requests\ModifierCodeStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ModifierCodes $resources, ModifierCodeStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\ModifierCode $resource
     * @param  \DentalSleepSolutions\Http\Requests\ModifierCodeUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ModifierCode $resource, ModifierCodeUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\ModifierCode $resource
     * @param  \DentalSleepSolutions\Http\Requests\ModifierCodeDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ModifierCode $resource, ModifierCodeDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
