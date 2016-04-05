<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\EdxCertificateStore;
use DentalSleepSolutions\Http\Requests\EdxCertificatUpdate;
use DentalSleepSolutions\Http\Requests\EdxCertificatDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\EdxCertificat;
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
     * @param  \DentalSleepSolutions\Contracts\Resources\EdxCertificat $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(EdxCertificat $resource)
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
     * @param  \DentalSleepSolutions\Contracts\Resources\EdxCertificat $resource
     * @param  \DentalSleepSolutions\Http\Requests\EdxCertificatUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EdxCertificat $resource, EdxCertificatUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\EdxCertificat $resource
     * @param  \DentalSleepSolutions\Http\Requests\EdxCertificatDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EdxCertificat $resource, EdxCertificatDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
