<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\TonsilsClinicalExamStore;
use DentalSleepSolutions\Http\Requests\TonsilsClinicalExamUpdate;
use DentalSleepSolutions\Http\Requests\TonsilsClinicalExamDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\TonsilsClinicalExam;
use DentalSleepSolutions\Contracts\Repositories\TonsilsClinicalExams;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class TonsilsClinicalExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TonsilsClinicalExams $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TonsilsClinicalExams $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TonsilsClinicalExam $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TonsilsClinicalExam $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TonsilsClinicalExams $resources
     * @param  \DentalSleepSolutions\Http\Requests\TonsilsClinicalExamStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TonsilsClinicalExams $resources, TonsilsClinicalExamStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\TonsilsClinicalExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\TonsilsClinicalExamUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TonsilsClinicalExam $resource, TonsilsClinicalExamUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TonsilsClinicalExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\TonsilsClinicalExamDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TonsilsClinicalExam $resource, TonsilsClinicalExamDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
