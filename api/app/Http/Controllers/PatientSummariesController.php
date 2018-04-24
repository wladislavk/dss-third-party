<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Services\AppointmentSummaries\TrackerNotesHandler;
use DentalSleepSolutions\Http\Requests\PatientSummary as PatientSummaryRequest;
use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;

class PatientSummariesController extends BaseRestController
{
    /** @var PatientSummaryRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/patient-summaries",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/PatientSummary")
     *                     )
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
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/PatientSummary")
     *                 )
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
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/PatientSummary")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function store(): JsonResponse
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
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        return parent::destroy($id);
    }

    /**
     * @SWG\Get(
     *     path="/patient-summaries/get-tracker-notes/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @param TrackerNotesHandler $trackerNotesHandler
     * @return JsonResponse
     */
    public function getTrackerNotes(int $id, TrackerNotesHandler $trackerNotesHandler): JsonResponse
    {
        $notes = $trackerNotesHandler->retrieve($id);
        return ApiResponse::responseOk('', $notes);
    }

    /**
     * @SWG\Put(
     *     path="/patient-summaries/update-tracker-notes",
     *     @SWG\Parameter(name="patient_id", in="query", type="integer", required=true),
     *     @SWG\Parameter(name="tracker_notes", in="query", type="string", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param PatientSummaryRequest $request
     * @param TrackerNotesHandler $trackerNotesHandler
     * @return JsonResponse
     */
    public function updateTrackerNotes(PatientSummaryRequest $request, TrackerNotesHandler $trackerNotesHandler): JsonResponse
    {
        $this->validate($request, $request->updateRules());

        $notes = $request->input('tracker_notes');
        $patientId = $request->input('patient_id');

        try {
            $trackerNotesHandler->update($patientId, $this->user->docid, $notes);
        } catch (GeneralException $e) {
            return ApiResponse::responseError($e->getMessage());
        }
        return ApiResponse::responseOk('Resource updated');
    }
}
