<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\TongueClinicalExamStore;
use DentalSleepSolutions\Http\Requests\TongueClinicalExamUpdate;
use DentalSleepSolutions\Http\Requests\TongueClinicalExamDestroy;
use DentalSleepSolutions\Contracts\Resources\TongueClinicalExam;
use DentalSleepSolutions\Contracts\Repositories\TongueClinicalExams;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class TongueClinicalExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TongueClinicalExams $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TongueClinicalExams $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TongueClinicalExam $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TongueClinicalExam $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TongueClinicalExams $resources
     * @param  \DentalSleepSolutions\Http\Requests\TongueClinicalExamStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TongueClinicalExams $resources, TongueClinicalExamStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\TongueClinicalExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\TongueClinicalExamUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TongueClinicalExam $resource, TongueClinicalExamUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TongueClinicalExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\TongueClinicalExamDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TongueClinicalExam $resource, TongueClinicalExamDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
