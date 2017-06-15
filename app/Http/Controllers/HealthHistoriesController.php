<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\HealthHistories;
use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Http\Requests\AbstractDestroyRequest;
use DentalSleepSolutions\Http\Requests\AbstractStoreRequest;
use DentalSleepSolutions\Http\Requests\AbstractUpdateRequest;
use Illuminate\Http\Request;

class HealthHistoriesController extends Controller
{
    public function index(Repository $resources)
    {
        return parent::index($resources);
    }

    public function show(Resource $resource)
    {
        return parent::show($resource);
    }

    public function store(Repository $resources, AbstractStoreRequest $request)
    {
        return parent::store($resources, $request);
    }

    public function update(Resource $resource, AbstractUpdateRequest $request)
    {
        return parent::update($resource, $request);
    }

    public function destroy(Resource $resource, AbstractDestroyRequest $request)
    {
        return parent::destroy($resource, $request);
    }

    /**
     * Get health histories by filter.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\HealthHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(HealthHistories $resources, Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $healthHistories = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $healthHistories);
    }
}
