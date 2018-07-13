<?php
namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Services\AppointmentSummaries\AppointmentSummaryCreator;
use DentalSleepSolutions\Services\AppointmentSummaries\AppointmentSummaryUpdater;
use DentalSleepSolutions\Services\AppointmentSummaries\TrackerStepRetriever;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Structs\AppointmentSummaryData;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class AppointmentSummariesController extends BaseRestController
{
    /** @var AppointmentSummaryRepository */
    protected $repository;

    /** @var LetterRepository */
    private $letterRepository;

    /** @var AppointmentSummaryCreator */
    private $appointmentSummaryCreator;

    /** @var AppointmentSummaryUpdater */
    private $appointmentSummaryUpdater;

    public function __construct(
        Auth $auth,
        Config $config,
        AbstractRepository $repository,
        Request $request,
        LetterRepository $letterRepository,
        AppointmentSummaryCreator $appointmentSummaryCreator,
        AppointmentSummaryUpdater $appointmentSummaryUpdater
    ) {
        parent::__construct($auth, $config, $repository, $request);
        $this->letterRepository = $letterRepository;
        $this->appointmentSummaryCreator = $appointmentSummaryCreator;
        $this->appointmentSummaryUpdater = $appointmentSummaryUpdater;
    }

    /**
     * @SWG\Get(
     *     path="/appt-summaries",
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
     *                         @SWG\Items(ref="#/definitions/AppointmentSummary")
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return parent::index();
    }

    /**
     * @SWG\Get(
     *     path="/appt-summaries/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/AppointmentSummary")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/appt-summaries",
     *     @SWG\Parameter(name="step_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer", required=true),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/AppointmentSummary")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="400", ref="#/responses/400_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        $stepId = (int)$this->request->input('step_id');
        $patientId = (int)$this->request->input('patient_id');
        $appointmentType = (int)$this->request->input('appt_type');
        $docId = $this->user()->normalizedDocId();
        $userId = $this->user()->userid;
        $triggerData = new SummaryLetterTriggerData();
        $triggerData->patientId = $patientId;
        $triggerData->stepId = $stepId;
        $triggerData->userId = $userId;
        $triggerData->docId = $docId;
        $triggerData->appointmentType = $appointmentType;
        try {
            $summary = $this->appointmentSummaryCreator->createAppointmentSummary($triggerData);
        } catch (GeneralException | RepositoryException $e) {
            return ApiResponse::responseError($e->getMessage(), 400);
        }
        return ApiResponse::responseOk('', $summary);
    }

    /**
     * @todo: currently this method works in the manner of HTTP PATCH rather than PUT. it should be rewritten to
     * @todo: conform to W3C spec for PUT
     *
     * @SWG\Put(
     *     path="/appt-summaries/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="comp_date", in="formData", type="string"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function update($id): JsonResponse
    {
        $data = new AppointmentSummaryData();
        $data->summaryId = $id;
        $data->patientId = (int)$this->request->input('patient_id');
        $data->docId = $this->user()->normalizedDocId();
        $data->userId = $this->user()->userid;
        $data->studyType = $this->request->input('type', null);
        $data->delayReason = $this->request->input('delay_reason', null);
        $data->nonComplianceReason = $this->request->input('noncomp_reason', null);
        $data->description = $this->request->input('reason', null);
        $deviceId = $this->request->input('device_id', null);
        if ($deviceId !== null) {
            $deviceId = (int)$deviceId;
        }
        $data->deviceId = $deviceId;
        $data->setCompletionDate($this->request->input('comp_date', ''));
        $data->setScheduledDate($this->request->input('scheduled', ''));
        try {
            $this->appointmentSummaryUpdater->updateAppointmentSummary($data);
        } catch (GeneralException $e) {
            return ApiResponse::responseError($e->getMessage(), 404);
        }
        return ApiResponse::responseOk('');
    }

    /**
     * @SWG\Delete(
     *     path="/appt-summaries/{id}",
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
        /** @var AppointmentSummary|null $resource */
        $resource = $this->repository->find($id);
        if (!$resource) {
            return ApiResponse::responseError("Appointment summary with ID $id not found", 404);
        }
        $resource->delete();
        $criteria = [
            'info_id' => $id,
        ];
        $now = new \DateTime();
        $data = [
            'deleted' => 1,
            'deleted_by' => $this->user()->userid,
            'deleted_on' => $now->format('Y-m-d H:i:s'),
        ];
        $this->letterRepository->updateBy($criteria, $data);
        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * @SWG\Get(
     *     path="/appt-summaries/by-patient/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getByPatient(int $id): JsonResponse
    {
        $data = $this->repository->getByPatient($id);
        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Get(
     *     path="/appt-summaries/final-rank/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @param TrackerStepRetriever $trackerStepRetriever
     * @return JsonResponse
     */
    public function getFinalRank(int $id, TrackerStepRetriever $trackerStepRetriever): JsonResponse
    {
        $finalRank = $trackerStepRetriever->getFinalRank($id);
        return ApiResponse::responseOk('', $finalRank->toArray());
    }

    /**
     * @SWG\Get(
     *     path="/appt-summaries/future-appointment/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getFutureAppointment(int $id): JsonResponse
    {
        $data = $this->repository->getFutureAppointment($id);
        return ApiResponse::responseOk('', $data);
    }
}
