<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\LedgerStatement;
use Illuminate\Http\Request;

class LedgerStatementsController extends Controller
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

    public function removeByIdAndPatientId(LedgerStatement $resource, Request $request)
    {
        $id = $request->input('id', 0);
        $patientId = $request->input('patient_id', 0);

        $resource->removeByIdAndPatientId($id, $patientId);

        return ApiResponse::responseOk('Resource deleted');
    }
}
