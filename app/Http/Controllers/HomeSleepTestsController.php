<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\HomeSleepTests;
use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Http\Requests\AbstractDestroyRequest;
use DentalSleepSolutions\Http\Requests\AbstractStoreRequest;
use DentalSleepSolutions\Http\Requests\AbstractUpdateRequest;
use Illuminate\Http\Request;

class HomeSleepTestsController extends Controller
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

    public function getUncompleted(HomeSleepTests $resources, Request $request)
    {
        $patientId = $request->input('patientId', 0);

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
