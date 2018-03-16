<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Helpers\AppointmentSummaryCreator;
use DentalSleepSolutions\Helpers\AppointmentSummaryUpdater;
use DentalSleepSolutions\Helpers\TrackerStepRetriever;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Eloquent\BaseRepository;

class AppointmentSummariesController extends BaseRestController
{
    /** @var AppointmentSummaryRepository */
    protected $repository;

    /** @var LetterRepository */
    private $letterRepository;

    public function __construct(
        Config $config,
        BaseRepository $repository,
        Request $request,
        LetterRepository $letterRepository
    ) {
        parent::__construct($config, $repository, $request);
        $this->letterRepository = $letterRepository;
    }

    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store()
    {
        $this->hasIp = false;
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var AppointmentSummary $resource */
        $resource = $this->repository->find($id);
        $resource->delete();
        $criteria = [
            'info_id' => $id,
        ];
        $now = new \DateTime();
        $data = [
            'deleted' => 1,
            'deleted_by' => $this->user->getUserIdOrZero(),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByPatient($id)
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFinalRank($id, TrackerStepRetriever $trackerStepRetriever)
    {
        $finalRank = $trackerStepRetriever->getFinalRank($id);
        return ApiResponse::responseOk('', $finalRank);
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

    /**
     * @param int $id
     * @param Request $request
     * @param AppointmentSummaryUpdater $appointmentSummaryUpdater
     * @return JsonResponse
     */
    public function updateAppointment(
        int $id,
        Request $request,
        AppointmentSummaryUpdater $appointmentSummaryUpdater
    ): JsonResponse {
        $patientId = (int)$request->input('patient_id');
        $docId = $this->user->getDocIdOrZero();
        $userId = $this->user->getUserIdOrZero();
        $completionDate = null;
        $rawCompletionDate = $request->input('comp_date', '');
        if ($rawCompletionDate) {
            $completionDate = new \DateTime($rawCompletionDate);
        }
        try {
            $appointmentSummaryUpdater->updateAppointmentSummary($id, $patientId, $userId, $docId, $completionDate);
        } catch (GeneralException $e) {
            return ApiResponse::responseError($e->getMessage(), 422);
        }
        return ApiResponse::responseOk('');
    }

    /**
     * @param Request $request
     * @param AppointmentSummaryCreator $appointmentSummaryCreator
     * @return JsonResponse
     */
    public function addAppointment(Request $request, AppointmentSummaryCreator $appointmentSummaryCreator): JsonResponse
    {
        $stepId = (int)$request->input('step_id');
        $patientId = (int)$request->input('patient_id');
        $docId = $this->user->getDocIdOrZero();
        $userId = $this->user->getUserIdOrZero();

        $triggerData = new SummaryLetterTriggerData();
        $triggerData->patientId = $patientId;
        $triggerData->stepId = $stepId;
        $triggerData->userId = $userId;
        $triggerData->docId = $docId;
        try {
            $appointmentSummaryCreator->createAppointmentSummary($triggerData);
        } catch (GeneralException $e) {
            return ApiResponse::responseError($e->getMessage(), 400);
        }
        return ApiResponse::responseOk('');
    }
}
