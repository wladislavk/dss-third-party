<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\ContactType;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class ContactTypesController extends BaseRestController
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

    public function getActiveNonCorporate(ContactType $resources)
    {
        $data = $resources->getActiveNonCorporateTypes();

        return ApiResponse::responseOk('', $data);
    }

    public function getPhysician(ContactType $resources)
    {
        $data = $resources->getPhysicianTypes();

        return ApiResponse::responseOk('', $data);
    }

    public function getWithFilter(ContactType $resources, Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $contactTypes = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $contactTypes);
    }

    public function getSortedContactTypes(ContactType $resources)
    {
        $contactTypes = $resources->getSorted();

        return ApiResponse::responseOk('', $contactTypes);
    }
}
