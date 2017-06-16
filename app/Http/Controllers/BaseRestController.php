<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Exceptions\ResourceNotFound;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

abstract class BaseRestController extends BaseController
{
    /** @var bool */
    protected $hasIp = true;

    /** @var Model|Repository */
    protected $resources;

    /** @var Request */
    protected $request;

    public function __construct(
        Repository $resources,
        Request $request
    ) {
        $this->resources = $resources;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            /** @var Resource $resource */
            $resource = $this->resources->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ResourceNotFound('Requested resource does not exist.');
        }
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store()
    {
        $this->validate($this->request, $this->request->storeRules());
        $data = $this->request->all();
        if ($this->hasIp) {
            $data = array_merge($this->request->all(), ['ip_address' => $this->request->ip()]);
        }
        $resource = $this->resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function update($id)
    {
        $this->validate($this->request, $this->request->updateRules());
        try {
            /** @var Resource $resource */
            $resource = $this->resources->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ResourceNotFound('Requested resource does not exist.');
        }
        $resource->update($this->request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->validate($this->request, $this->request->destroyRules());
        try {
            /** @var Resource $resource */
            $resource = $this->resources->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ResourceNotFound('Requested resource does not exist.');
        }
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
