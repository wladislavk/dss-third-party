<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\Company;
use DentalSleepSolutions\Contracts\Repositories\Companies;

class CompaniesController extends BaseRestController
{
    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
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
