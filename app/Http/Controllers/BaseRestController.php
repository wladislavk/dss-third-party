<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Http\Requests\AbstractDestroyRequest;
use DentalSleepSolutions\Http\Requests\AbstractStoreRequest;
use DentalSleepSolutions\Http\Requests\AbstractUpdateRequest;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

abstract class BaseRestController extends BaseController
{
    /** @var bool */
    protected $hasIp = true;

    /**
     * Display a listing of the resource.
     *
     * @param Repository $resources
     * @return JsonResponse
     */
    public function index(Repository $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param Resource $resource
     * @return JsonResponse
     */
    public function show(Resource $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Repository $resources
     * @param AbstractStoreRequest $request
     * @return JsonResponse
     */
    public function store(Repository $resources, AbstractStoreRequest $request)
    {
        $data = $request->all();
        if ($this->hasIp) {
            $data = array_merge($request->all(), ['ip_address' => $request->ip()]);
        }
        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Resource $resource
     * @param AbstractUpdateRequest $request
     * @return JsonResponse
     */
    public function update(Resource $resource, AbstractUpdateRequest $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Resource $resource
     * @param AbstractDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(Resource $resource, AbstractDestroyRequest $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
