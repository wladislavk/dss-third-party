<?php
namespace DentalSleepSolutions\Helpers;

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
    private const STEPS_WITH_LETTERS = [4, 5, 6, 8, 9, 11, 12, 13, 14];

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

        if ($data->stepId == 7) {
            $this->createClinicalExam($data);
        }
        $newAppointmentSummary = new AppointmentSummary();
        $newAppointmentSummary->patientid = $data->patientId;
        $newAppointmentSummary->segmentid = $data->stepId;
        $newAppointmentSummary->appointment_type = 1;
        $newAppointmentSummary->date_completed = new \DateTime();
        $newAppointmentSummary->save();
        $data->infoId = $newAppointmentSummary->id;
        if ($data->infoId) {
            $this->deleteFutureAppointment($data->patientId);
        }
        $trigger = $this->letterTriggerFactory->getLetterTrigger($data->stepId);
        if ($createLetters && in_array($data->stepId, self::STEPS_WITH_LETTERS)) {
            $trigger->triggerLetter($data);
            switch ($data->stepId) {
                case 6:
                    $firstTrigger = new FirstRefusedTreatmentTrigger();
                    $letterIds[] = $firstTrigger->triggerLetter($data);
                    $secondTrigger = new SecondRefusedTreatmentTrigger();
                    $letterIds[] = $secondTrigger->triggerLetter($data);
                    break;
            }
        }
    }

    /**
     * @param SummaryLetterTriggerData $data
     */
    private function createClinicalExam(SummaryLetterTriggerData $data): void
    {
        /** @var TmjClinicalExam[] $clinicalExams */
        $clinicalExams = $this->clinicalExamRepository->findByField('patientid', $data->patientId);
        if (isset($clinicalExams[0])) {
            $clinicalExam = $clinicalExams[0];
        } else {
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
        if ($futureAppointment) {
            try {
                $futureAppointment->delete();
            } catch (\Exception $e) {
                throw new GeneralException('Could not delete future appointment: ' . $e->getMessage());
            }
        }
    }
}
