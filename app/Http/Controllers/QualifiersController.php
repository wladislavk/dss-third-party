<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\Qualifier;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class QualifiersController extends BaseRestController
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

    public function getActive(Qualifier $resource)
    {
        $data = $resource->getActive();

        return ApiResponse::responseOk('', $data);
    }
}
