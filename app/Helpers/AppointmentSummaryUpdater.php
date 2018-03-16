<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Exceptions\GeneralException;

class AppointmentSummaryUpdater
{
    /** @var TmjClinicalExamRepository */
    private $clinicalExamRepository;

    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    public function __construct(
        TmjClinicalExamRepository $clinicalExamRepository,
        AppointmentSummaryRepository $appointmentSummaryRepository
    ) {
        $this->clinicalExamRepository = $clinicalExamRepository;
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
    }

    /**
     * @param int $summaryId
     * @param int $patientId
     * @param int $userId
     * @param int $docId
     * @param \DateTime|null $completionDate
     * @throws GeneralException
     */
    public function updateAppointmentSummary(
        int $summaryId,
        int $patientId,
        int $userId,
        int $docId,
        ?\DateTime $completionDate
    ) {
        /** @var AppointmentSummary|null $summary */
        $summary = $this->appointmentSummaryRepository->find($summaryId);
        if (!$summary) {
            throw new GeneralException("Appointment summary with ID $summaryId not found");
        }
        if ($summary->segmentid == 7) {
            $devicesByPatient = $this->appointmentSummaryRepository->getByPatient($patientId);
            if (isset($devicesByPatient[0]) && $summaryId == $devicesByPatient[0]->id) {
                $this->updateDeviceDate($patientId, $userId, $docId, $completionDate);
            }
        }

        if (!$completionDate) {
            $completionDate = new \DateTime();
        }
        $summary->date_completed = $completionDate;
        $summary->save();
    }

    /**
     * @param int $patientId
     * @param int $userId
     * @param int $docId
     * @param \DateTime|null $completionDate
     */
    private function updateDeviceDate(
        int $patientId,
        int $userId,
        int $docId,
        ?\DateTime $completionDate
    ): void {
        /** @var TmjClinicalExam|null $clinicalExam */
        $clinicalExam = $this->clinicalExamRepository->findByField('patientid', $patientId);
        if ($clinicalExam) {
            $clinicalExam->dentaldevice_date = null;
        } else {
            $clinicalExam = new TmjClinicalExam();
            $clinicalExam->patientid = $patientId;
            $clinicalExam->userid = $userId;
            $clinicalExam->docid = $docId;
        }
        if ($completionDate) {
            $clinicalExam->dentaldevice_date = $completionDate;
        }
        $clinicalExam->save();
    }
}
