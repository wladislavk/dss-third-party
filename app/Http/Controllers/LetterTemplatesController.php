<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LetterTemplateStore;
use DentalSleepSolutions\Http\Requests\LetterTemplateUpdate;
use DentalSleepSolutions\Http\Requests\LetterTemplateDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\LetterTemplate;
use DentalSleepSolutions\Contracts\Repositories\LetterTemplates;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LetterTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LetterTemplates $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LetterTemplates $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LetterTemplate $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LetterTemplate $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\LetterTemplates $resources
     * @param  \DentalSleepSolutions\Http\Requests\LetterTemplateStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LetterTemplates $resources, LetterTemplateStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LetterTemplate $resource
     * @param  \DentalSleepSolutions\Http\Requests\LetterTemplateUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LetterTemplate $resource, LetterTemplateUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\LetterTemplate $resource
     * @param  \DentalSleepSolutions\Http\Requests\LetterTemplateDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LetterTemplate $resource, LetterTemplateDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
