<?php
namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Constants\TrackerSteps;
use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\TmjClinicalExamRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Factories\LetterTriggerFactory;
use DentalSleepSolutions\Factories\RepositoryFactory;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use DentalSleepSolutions\Wrappers\DBChangeWrapper;
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

    /** @var DBChangeWrapper */
    private $dbChangeWrapper;

    /**
     * @param LetterTriggerFactory $letterTriggerFactory
     * @param RepositoryFactory $repositoryFactory
     * @param DBChangeWrapper $dbChangeWrapper
     * @throws GeneralException
     */
    public function __construct(
        LetterTriggerFactory $letterTriggerFactory,
        RepositoryFactory $repositoryFactory,
        DBChangeWrapper $dbChangeWrapper
    ) {
        $this->letterTriggerFactory = $letterTriggerFactory;
        $this->appointmentSummaryRepository = $repositoryFactory->getRepository(AppointmentSummaryRepository::class);
        $this->clinicalExamRepository = $repositoryFactory->getRepository(TmjClinicalExamRepository::class);
        $this->userRepository = $repositoryFactory->getRepository(UserRepository::class);
        $this->dbChangeWrapper = $dbChangeWrapper;
    }

    /**
     * @param SummaryLetterTriggerData $data
     * @throws GeneralException
     * @throws RepositoryException
     */
    public function createAppointmentSummary(SummaryLetterTriggerData $data): void
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
        $newAppointmentSummary->appointment_type = 1;
        $newAppointmentSummary->date_completed = new \DateTime();
        $this->dbChangeWrapper->save($newAppointmentSummary);
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
