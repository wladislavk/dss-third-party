<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\DentalClinicalExamStore;
use DentalSleepSolutions\Http\Requests\DentalClinicalExamUpdate;
use DentalSleepSolutions\Http\Requests\DentalClinicalExamDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\DentalClinicalExam;
use DentalSleepSolutions\Contracts\Repositories\DentalClinicalExams;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class DentalClinicalExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\DentalClinicalExams $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DentalClinicalExams $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\DentalClinicalExam $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DentalClinicalExam $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\DentalClinicalExams $resources
     * @param  \DentalSleepSolutions\Http\Requests\DentalClinicalExamStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DentalClinicalExams $resources, DentalClinicalExamStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\DentalClinicalExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\DentalClinicalExamUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DentalClinicalExam $resource, DentalClinicalExamUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\DentalClinicalExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\DentalClinicalExamDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DentalClinicalExam $resource, DentalClinicalExamDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
