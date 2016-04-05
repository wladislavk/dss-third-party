<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\EdxCertificateStore;
use DentalSleepSolutions\Http\Requests\EdxCertificateUpdate;
use DentalSleepSolutions\Http\Requests\EdxCertificateDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\EdxCertificate;
use DentalSleepSolutions\Contracts\Repositories\EdxCertificates;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class EdxCertificatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\EdxCertificates $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(EdxCertificates $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\EdxCertificate $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(EdxCertificate $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\EdxCertificates $resources
     * @param  \DentalSleepSolutions\Http\Requests\EdxCertificateStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EdxCertificates $resources, EdxCertificateStore $request)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\EdxCertificate $resource
     * @param  \DentalSleepSolutions\Http\Requests\EdxCertificateUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EdxCertificate $resource, EdxCertificateUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\EdxCertificate $resource
     * @param  \DentalSleepSolutions\Http\Requests\EdxCertificateDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EdxCertificate $resource, EdxCertificateDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
