<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\HomeSleepTestStore;
use DentalSleepSolutions\Http\Requests\HomeSleepTestUpdate;
use DentalSleepSolutions\Http\Requests\HomeSleepTestDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\HomeSleepTest;
use DentalSleepSolutions\Contracts\Repositories\HomeSleepTests;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class HomeSleepTestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\HomeSleepTests $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(HomeSleepTests $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\HomeSleepTest $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(HomeSleepTest $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\HomeSleepTests $resources
     * @param  \DentalSleepSolutions\Http\Requests\HomeSleepTestStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(HomeSleepTests $resources, HomeSleepTestStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\HomeSleepTest $resource
     * @param  \DentalSleepSolutions\Http\Requests\HomeSleepTestUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(HomeSleepTest $resource, HomeSleepTestUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\HomeSleepTest $resource
     * @param  \DentalSleepSolutions\Http\Requests\HomeSleepTestDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(HomeSleepTest $resource, HomeSleepTestDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getUncompleted(HomeSleepTests $resources, Request $request)
    {
        $patientId = $request->input('patientId') ?: 0;

        $data = $resources->getUncompleted($patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getByType($type, HomeSleepTests $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        switch ($type) {
            case 'completed':
                $data = $resources->getCompleted($docId);
                break;
            case 'requested':
                $data = $resources->getRequested($docId);
                break;
            case 'rejected':
                $data = $resources->getRejected($docId);
                break;
            default:
                $data = [];
                break;
        }

        return ApiResponse::responseOk('', $data);
    }
}
