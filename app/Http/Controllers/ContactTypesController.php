<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Http\Requests\AbstractDestroyRequest;
use DentalSleepSolutions\Http\Requests\AbstractStoreRequest;
use DentalSleepSolutions\Http\Requests\AbstractUpdateRequest;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\ContactTypes;
use Illuminate\Http\Request;

class ContactTypesController extends Controller
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

    public function getActiveNonCorporate(ContactTypes $resources)
    {
        $data = $resources->getActiveNonCorporateTypes();

        return ApiResponse::responseOk('', $data);
    }

    public function getPhysician(ContactTypes $resources)
    {
        $data = $resources->getPhysicianTypes();

        return ApiResponse::responseOk('', $data);
    }

    public function getWithFilter(ContactTypes $resources, Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $contactTypes = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $contactTypes);
    }

    public function getSortedContactTypes(ContactTypes $resources)
    {
        $contactTypes = $resources->getSorted();

        return ApiResponse::responseOk('', $contactTypes);
    }
}
