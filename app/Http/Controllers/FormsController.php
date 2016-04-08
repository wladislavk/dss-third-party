<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\FormStore;
use DentalSleepSolutions\Http\Requests\FormUpdate;
use DentalSleepSolutions\Http\Requests\FormDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Form;
use DentalSleepSolutions\Contracts\Repositories\Forms;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Forms $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Forms $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Form $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Form $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Forms $resources
     * @param  \DentalSleepSolutions\Http\Requests\FormStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Forms $resources, FormStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Form $resource
     * @param  \DentalSleepSolutions\Http\Requests\FormUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Form $resource, FormUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Form $resource
     * @param  \DentalSleepSolutions\Http\Requests\FormDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Form $resource, FormDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
