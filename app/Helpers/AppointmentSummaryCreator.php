<?php
namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\TrackerSteps;
use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\LetterTriggerFactory;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use Prettus\Repository\Exceptions\RepositoryException;

class AppointmentSummaryCreator
{
    /** @var LetterTriggerFactory */
    private $letterTriggerFactory;

    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    /** @var TmjClinicalExamRepository */
    private $clinicalExamRepository;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        LetterTriggerFactory $letterTriggerFactory,
        AppointmentSummaryRepository $appointmentSummaryRepository,
        TmjClinicalExamRepository $clinicalExamRepository,
        UserRepository $userRepository
    ) {
        $this->letterTriggerFactory = $letterTriggerFactory;
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
        $this->clinicalExamRepository = $clinicalExamRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param SummaryLetterTriggerData $data
     * @throws GeneralException
     * @throws RepositoryException
     */
    public function createAppointmentSummary(SummaryLetterTriggerData $data): void
    {
        $numSteps = null;
        $letterRow = $this->userRepository->getLetterInfo($data->docId);
        $createLetters = false;
        if ($letterRow && $letterRow->use_letters && $letterRow->tracker_letters) {
            $createLetters = true;
        }

        if ($data->stepId == TrackerSteps::DEVICE_DELIVERY_ID) {
            $this->createClinicalExam($data);
        }
        $newAppointmentSummary = new AppointmentSummary();
        $newAppointmentSummary->patientid = $data->patientId;
        $newAppointmentSummary->segmentid = $data->stepId;
        $newAppointmentSummary->appointment_type = 1;
        $newAppointmentSummary->date_completed = new \DateTime();
        $newAppointmentSummary->save();
        $data->infoId = $newAppointmentSummary->id;

        $this->deleteFutureAppointment($data->patientId);

        if ($createLetters && in_array($data->stepId, TrackerSteps::STEPS_WITH_LETTERS)) {
            $triggers = $this->letterTriggerFactory->getLetterTriggers($data->stepId);
            foreach ($triggers as $trigger) {
                $trigger->triggerLetter($data);
            }
        }
    }

    /**
     * @param SummaryLetterTriggerData $data
     */
    private function createClinicalExam(SummaryLetterTriggerData $data): void
    {
        /** @var TmjClinicalExam|null $clinicalExams */
        $clinicalExam = $this->clinicalExamRepository->getOneBy('patientid', $data->patientId);
        if (!$clinicalExam) {
            $clinicalExam = new TmjClinicalExam();
            $clinicalExam->patientid = $data->patientId;
            $clinicalExam->userid = $data->userId;
            $clinicalExam->docid = $data->docId;
        }
        $clinicalExam->dentaldevice_date = new \DateTime();
        $clinicalExam->save();
    }

    /**
     * @param int $patientId
     * @throws GeneralException
     */
    private function deleteFutureAppointment(int $patientId): void
    {
        $futureAppointment = $this->appointmentSummaryRepository->getFutureAppointment($patientId);
        if (!$futureAppointment) {
            return;
        }
        try {
            $futureAppointment->delete();
        } catch (\Exception $e) {
            throw new GeneralException('Could not delete future appointment: ' . $e->getMessage());
        }
    }
}
