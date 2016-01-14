<?php

namespace DentalSleepSolutions\Http\Controllers;

use Illuminate\Http\Request;
use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\PayerStore;
use DentalSleepSolutions\Contracts\Resources\Payer;
use DentalSleepSolutions\Http\Requests\PayerUpdate;
use DentalSleepSolutions\Http\Requests\PayerDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Repositories\Payers;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Payers $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Payers $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Payer $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Payer $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Get array of enrollment required fields for a payer.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Payer  $payer
     * @return \Illuminate\Http\JsonResponse
     */
    public function requiredFields(Payer $payer, Request $request)
    {
        $fields = $payer->requiredFields($request->get('endpoint'));

        return ApiResponse::responseOk('', $fields);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Payers $resources
     * @param  \DentalSleepSolutions\Http\Requests\PayerStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Payers $resources, PayerStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Payer $resource
     * @param  \DentalSleepSolutions\Http\Requests\PayerUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Payer $resource, PayerUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Payer $resource
     * @param  \DentalSleepSolutions\Http\Requests\PayerDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Payer $resource, PayerDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
