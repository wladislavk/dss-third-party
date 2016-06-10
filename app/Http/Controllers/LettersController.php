<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LetterStore;
use DentalSleepSolutions\Http\Requests\LetterUpdate;
use DentalSleepSolutions\Http\Requests\LetterDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Letter;
use DentalSleepSolutions\Contracts\Repositories\Letters;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LettersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Letters $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Letters $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Letter $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Letter $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Letters $resources
     * @param  \DentalSleepSolutions\Http\Requests\LetterStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Letters $resources, LetterStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Letter $resource
     * @param  \DentalSleepSolutions\Http\Requests\LetterUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Letter $resource, LetterUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Letter $resource
     * @param  \DentalSleepSolutions\Http\Requests\LetterDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Letter $resource, LetterDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getPending(Letters $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getPending($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getUnmailed(Letters $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getUnmailed($docId);

        return ApiResponse::responseOk('', $data);
    }
}
