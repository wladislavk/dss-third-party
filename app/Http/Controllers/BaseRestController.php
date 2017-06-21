<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Exceptions\ResourceNotFound;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

abstract class BaseRestController extends Controller
{
    /** @var bool */
    protected $hasIp = true;

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
        /** @var Resource $resource */
        $resource = $this->resources->findOrFail($id);
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
        /** @var Resource $resource */
        $resource = $this->resources->findOrFail($id);
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
        /** @var Resource $resource */
        $resource = $this->resources->findOrFail($id);
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }
}
