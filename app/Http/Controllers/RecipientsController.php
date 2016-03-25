<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\RecipientStore;
use DentalSleepSolutions\Http\Requests\RecipientUpdate;
use DentalSleepSolutions\Http\Requests\RecipientDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Recipient;
use DentalSleepSolutions\Contracts\Repositories\Recipients;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class RecipientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Recipients $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Recipients $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Recipient $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Recipient $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Recipients $resources
     * @param  \DentalSleepSolutions\Http\Requests\RecipientStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Recipients $resources, RecipientStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Recipient $resource
     * @param  \DentalSleepSolutions\Http\Requests\RecipientUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Recipient $resource, RecipientUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Recipient $resource
     * @param  \DentalSleepSolutions\Http\Requests\RecipientDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Recipient $resource, RecipientDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
