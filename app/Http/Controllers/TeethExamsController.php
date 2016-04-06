<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\TeethExamStore;
use DentalSleepSolutions\Http\Requests\TeethExamUpdate;
use DentalSleepSolutions\Http\Requests\TeethExamDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\TeethExam;
use DentalSleepSolutions\Contracts\Repositories\TeethExams;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class TeethExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TeethExams $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TeethExams $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TeethExam $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TeethExam $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\TeethExams $resources
     * @param  \DentalSleepSolutions\Http\Requests\TeethExamStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TeethExams $resources, TeethExamStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\TeethExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\TeethExamUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TeethExam $resource, TeethExamUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\TeethExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\TeethExamDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TeethExam $resource, TeethExamDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
