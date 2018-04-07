<?php
namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\SummaryLetterTable;
use DentalSleepSolutions\Constants\TrackerSteps;
use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\RepositoryFactory;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;
use Prettus\Repository\Exceptions\RepositoryException;

class AppointmentSummaryCreator
{
    /** @var SummaryLetterTrigger */
    private $summaryLetterTrigger;

    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    /** @var TmjClinicalExamRepository */
    private $clinicalExamRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var DBChangeWrapper */
    private $dbChangeWrapper;

    /**
     * @param SummaryLetterTrigger $summaryLetterTrigger
     * @param RepositoryFactory $repositoryFactory
     * @param DBChangeWrapper $dbChangeWrapper
     * @throws GeneralException
     */
    public function __construct(
        SummaryLetterTrigger $summaryLetterTrigger,
        RepositoryFactory $repositoryFactory,
        DBChangeWrapper $dbChangeWrapper
    ) {
        $this->summaryLetterTrigger = $summaryLetterTrigger;
        $this->appointmentSummaryRepository = $repositoryFactory->getRepository(AppointmentSummaryRepository::class);
        $this->clinicalExamRepository = $repositoryFactory->getRepository(TmjClinicalExamRepository::class);
        $this->userRepository = $repositoryFactory->getRepository(UserRepository::class);
        $this->dbChangeWrapper = $dbChangeWrapper;
    }

    /**
     * @param SummaryLetterTriggerData $data
     * @return AppointmentSummary
     * @throws GeneralException
     * @throws RepositoryException
     */
    public function createAppointmentSummary(SummaryLetterTriggerData $data): AppointmentSummary
    {
        /** @var User|null $doctor */
        $doctor = $this->userRepository->find($data->docId);
        $createLetters = false;
        if ($doctor && $doctor->use_letters && $doctor->tracker_letters) {
            $createLetters = true;
        }

        if ($data->stepId == TrackerSteps::DEVICE_DELIVERY_ID) {
            $this->createClinicalExam($data);
        }
        $newAppointmentSummary = new AppointmentSummary();
        $newAppointmentSummary->patientid = $data->patientId;
        $newAppointmentSummary->segmentid = $data->stepId;
        $newAppointmentSummary->appointment_type = $data->appointmentType;
        $newAppointmentSummary->date_completed = null;
        if ($data->appointmentType == 1) {
            $newAppointmentSummary->date_completed = new \DateTime();
        }
        $this->dbChangeWrapper->save($newAppointmentSummary);
        $data->infoId = $newAppointmentSummary->id;

        if ($data->appointmentType == 1) {
            $this->deleteFutureAppointment($data->patientId);
        }

        $stepsWithLetters = array_keys(SummaryLetterTable::SUMMARY_LETTERS);
        if ($createLetters && in_array($data->stepId, $stepsWithLetters)) {
            $this->triggerLetters($data);
        }
        return $newAppointmentSummary;
    }

    /**
     * @param SummaryLetterTriggerData $data
     * @throws GeneralException
     * @throws RepositoryException
     */
    private function triggerLetters(SummaryLetterTriggerData $data)
    {
        if (!is_array(SummaryLetterTable::SUMMARY_LETTERS[$data->stepId])) {
            throw new GeneralException("Letter data for step with ID {$data->stepId} is not set");
        }
        $tableElements = SummaryLetterTable::SUMMARY_LETTERS[$data->stepId];
        foreach ($tableElements as $tableElement) {
            $this->summaryLetterTrigger->triggerLetter($data, $tableElement);
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
        $this->dbChangeWrapper->save($clinicalExam);
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
            $this->dbChangeWrapper->delete($futureAppointment);
        } catch (\Exception $e) {
            throw new GeneralException('Could not delete future appointment: ' . $e->getMessage());
        }
    }
}
