<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\JointExamStore;
use DentalSleepSolutions\Http\Requests\JointExamUpdate;
use DentalSleepSolutions\Http\Requests\JointExamDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\JointExam;
use DentalSleepSolutions\Contracts\Repositories\JointExams;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class JointExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\JointExams $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(JointExams $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\JointExam $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(JointExam $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\JointExams $resources
     * @param  \DentalSleepSolutions\Http\Requests\JointExamStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(JointExams $resources, JointExamStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\JointExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\JointExamUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(JointExam $resource, JointExamUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\JointExam $resource
     * @param  \DentalSleepSolutions\Http\Requests\JointExamDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(JointExam $resource, JointExamDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
