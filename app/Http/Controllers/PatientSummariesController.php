<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\PatientSummaryUpdate;
use DentalSleepSolutions\Contracts\Resources\PatientSummary;

class PatientSummariesController extends BaseRestController
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

    public function updateTrackerNotes(PatientSummary $resource, PatientSummaryUpdate $request)
    {
        $notes = $request->input('tracker_notes', '');
        $patientId = $request->input('patient_id', 0);
        $docId = $this->currentUser->docid ?: 0;

        $resource->updateTrackerNotes($patientId, $docId, $notes);

        return ApiResponse::responseOk('Resource updated');
    }
}
