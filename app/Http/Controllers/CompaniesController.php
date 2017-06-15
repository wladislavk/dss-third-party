<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Http\Requests\AbstractDestroyRequest;
use DentalSleepSolutions\Http\Requests\AbstractStoreRequest;
use DentalSleepSolutions\Http\Requests\AbstractUpdateRequest;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\Company;
use DentalSleepSolutions\Contracts\Repositories\Companies;

class CompaniesController extends Controller
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

    public function getCompanyLogo(Company $resource)
    {
        $userId = $this->currentUser->id ?: 0;

        $data = $resource->getCompanyLogo($userId);

        return ApiResponse::responseOk('', $data);
    }

    public function getHomeSleepTestCompanies(Companies $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getHomeSleepTestCompanies($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getBillingExclusiveCompany(Company $resource)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resource->getBillingExclusiveCompany($docId);

        return ApiResponse::responseOk('', $data);
    }
}
