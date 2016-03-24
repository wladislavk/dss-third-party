<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\CustomLetterTemplateStore;
use DentalSleepSolutions\Http\Requests\CustomLetterTemplateUpdate;
use DentalSleepSolutions\Http\Requests\CustomLetterTemplateDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\CustomLetterTemplate;
use DentalSleepSolutions\Contracts\Repositories\CustomLetterTemplates;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class CustomLetterTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\CustomLetterTemplates $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CustomLetterTemplates $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\CustomLetterTemplate $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CustomLetterTemplate $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\CustomLetterTemplates $resources
     * @param  \DentalSleepSolutions\Http\Requests\CustomLetterTemplateStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomLetterTemplates $resources, CustomLetterTemplateStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\CustomLetterTemplate $resource
     * @param  \DentalSleepSolutions\Http\Requests\CustomLetterTemplateUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CustomLetterTemplate $resource, CustomLetterTemplateUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\CustomLetterTemplate $resource
     * @param  \DentalSleepSolutions\Http\Requests\CustomLetterTemplateDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CustomLetterTemplate $resource, CustomLetterTemplateDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
