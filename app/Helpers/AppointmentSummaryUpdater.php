<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\TrackerSteps;
use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Structs\AppointmentSummaryData;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;

class AppointmentSummaryUpdater
{
    /** @var TmjClinicalExamRepository */
    private $clinicalExamRepository;

    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    /** @var DBChangeWrapper */
    private $dbChangeWrapper;

    public function __construct(
        TmjClinicalExamRepository $clinicalExamRepository,
        AppointmentSummaryRepository $appointmentSummaryRepository,
        DBChangeWrapper $dbChangeWrapper
    ) {
        $this->clinicalExamRepository = $clinicalExamRepository;
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
        $this->dbChangeWrapper = $dbChangeWrapper;
    }

    /**
     * @param AppointmentSummaryData $data
     * @throws GeneralException
     */
    public function updateAppointmentSummary(AppointmentSummaryData $data): void
    {
        /** @var AppointmentSummary|null $summary */
        $summary = $this->appointmentSummaryRepository->find($data->summaryId);
        if (!$summary) {
            throw new GeneralException("Appointment summary with ID {$data->summaryId} not found");
        }
        if ($summary->segmentid == TrackerSteps::DEVICE_DELIVERY_ID && $this->isLastSummaryForPatient($data)) {
            $this->updateClinicalExam($data);
        }
        if (!$data->completionDate) {
            $data->completionDate = new \DateTime();
        }
        $summary->date_completed = $data->completionDate;
        $this->dbChangeWrapper->save($summary);
    }

    /**
     * @param AppointmentSummaryData $data
     * @return bool
     */
    private function isLastSummaryForPatient(AppointmentSummaryData $data): bool
    {
        $summariesByPatient = $this->appointmentSummaryRepository->getByPatient($data->patientId);
        if (isset($summariesByPatient[0]) && $data->summaryId == $summariesByPatient[0]->id) {
            return true;
        }
        return false;
    }

    /**
     * @param AppointmentSummaryData $data
     */
    private function updateClinicalExam(AppointmentSummaryData $data): void
    {
        /** @var TmjClinicalExam|null $clinicalExam */
        $clinicalExam = $this->clinicalExamRepository->getOneBy('patientid', $data->patientId);
        if (!$clinicalExam) {
            $clinicalExam = new TmjClinicalExam();
            $clinicalExam->patientid = $data->patientId;
            $clinicalExam->userid = $data->userId;
            $clinicalExam->docid = $data->docId;
        }
        $clinicalExam->dentaldevice_date = null;
        if ($data->completionDate) {
            $clinicalExam->dentaldevice_date = $data->completionDate;
        }
        $this->dbChangeWrapper->save($clinicalExam);
    }
}
