<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\Locations;

class LocationsController extends BaseRestController
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

    public function getDoctorLocations(Locations $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getDoctorLocations($docId);

        return ApiResponse::responseOk('', $data);
    }
}
