<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\TmjClinicalExamStore;
use DentalSleepSolutions\Http\Requests\TmjClinicalExamUpdate;
use DentalSleepSolutions\Http\Requests\TmjClinicalExamDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\TmjClinicalExam;
use DentalSleepSolutions\Contracts\Repositories\TmjClinicalExams;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class TmjClinicalExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TmjClinicalExams $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TmjClinicalExams $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TmjClinicalExam $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TmjClinicalExam $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TmjClinicalExams $resources
     * @param  \DentalSleepSolutions\Http\Requests\TmjClinicalExamStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TmjClinicalExams $resources, TmjClinicalExamStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\TmjClinicalExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\TmjClinicalExamUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TmjClinicalExam $resource, TmjClinicalExamUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TmjClinicalExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\TmjClinicalExamDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TmjClinicalExam $resource, TmjClinicalExamDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
