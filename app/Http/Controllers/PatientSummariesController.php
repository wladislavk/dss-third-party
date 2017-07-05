<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\PatientSummaryUpdate;
use DentalSleepSolutions\Contracts\Resources\PatientSummary;

class PatientSummariesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/patient-summaries",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/PatientSummary"))
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * @SWG\Get(
     *     path="/patient-summaries/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/PatientSummary"))
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/patient-summaries",
     *     @SWG\Parameter(name="pid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="fspage1_complete", in="formData", type="boolean"),
     *     @SWG\Parameter(name="next_visit", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="last_visit", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="last_treatment", in="formData", type="string"),
     *     @SWG\Parameter(name="appliance", in="formData", type="integer"),
     *     @SWG\Parameter(name="delivery_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="vob", in="formData", type="string"),
     *     @SWG\Parameter(name="ledger", in="formData", type="string", pattern="^-?[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="patient_info", in="formData", type="boolean"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/PatientSummary"))
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        $this->hasIp = false;
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/patient-summaries/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="pid", in="formData", type="integer"),
     *     @SWG\Parameter(name="fspage1_complete", in="formData", type="boolean"),
     *     @SWG\Parameter(name="next_visit", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="last_visit", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="last_treatment", in="formData", type="string"),
     *     @SWG\Parameter(name="appliance", in="formData", type="integer"),
     *     @SWG\Parameter(name="delivery_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="vob", in="formData", type="string"),
     *     @SWG\Parameter(name="ledger", in="formData", type="string", pattern="^-?[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="patient_info", in="formData", type="boolean"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/patient-summaries/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * @SWG\Put(
     *     path="/patient-summaries/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="pid", in="formData", type="integer"),
     *     @SWG\Parameter(name="fspage1_complete", in="formData", type="boolean"),
     *     @SWG\Parameter(name="next_visit", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="last_visit", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="last_treatment", in="formData", type="string"),
     *     @SWG\Parameter(name="appliance", in="formData", type="integer"),
     *     @SWG\Parameter(name="delivery_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="vob", in="formData", type="string"),
     *     @SWG\Parameter(name="ledger", in="formData", type="string", pattern="^-?[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="patient_info", in="formData", type="boolean"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function updateTrackerNotes(PatientSummary $resource, PatientSummaryUpdate $request)
    {
        $notes = $request->input('tracker_notes', '');
        $patientId = $request->input('patient_id', 0);
        $docId = $this->currentUser->docid ?: 0;

        $resource->updateTrackerNotes($patientId, $docId, $notes);

        return ApiResponse::responseOk('Resource updated');
    }
}
