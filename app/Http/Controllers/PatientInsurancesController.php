<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientInsurance;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class PatientInsurancesController extends BaseRestController
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
        $this->hasIp = false;
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

    public function getCurrent(PatientInsurance $resources, Request $request)
    {
        $patientId = $request->input('patientId', 0);
        $docId     = $this->currentUser->docid ?: 0;

        $data = $resources->getCurrent($docId, $patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function getNumber(PatientInsurance $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }
}
