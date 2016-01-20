<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\AssessmentStore;
use DentalSleepSolutions\Http\Requests\AssessmentUpdate;
use DentalSleepSolutions\Http\Requests\AssessmentDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Assessment;
use DentalSleepSolutions\Contracts\Repositories\Assessments;
use Carbon\Carbon;

class AssessmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Assessments $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Assessments $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Assessment $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Assessment $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Assessments $resources
     * @param  \DentalSleepSolutions\Http\Requests\AssessmentStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Assessments $resources, AssessmentStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Assessment $resource
     * @param  \DentalSleepSolutions\Http\Requests\AssessmentUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Assessment $resource, AssessmentUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Assessment $resource
     * @param  \DentalSleepSolutions\Http\Requests\AssessmentDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Assessment $resource, AssessmentDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
