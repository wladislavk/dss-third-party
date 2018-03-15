<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\AppointmentSummaryRepository;
use DentalSleepSolutions\Structs\SummaryLetterTriggerData;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Helpers\IdListCleaner;

abstract class AbstractSummaryCompletedTrigger extends AbstractSummaryLetterTrigger
{
    /** @var AppointmentSummaryRepository */
    private $appointmentSummaryRepository;

    public function __construct(
        IdListCleaner $idListCleaner,
        PatientRepository $patientRepository,
        ContactRepository $contactRepository,
        UserRepository $userRepository,
        AppointmentSummaryRepository $appointmentSummaryRepository
    ) {
        $this->appointmentSummaryRepository = $appointmentSummaryRepository;
        parent::__construct($idListCleaner, $patientRepository, $contactRepository, $userRepository);
    }

    /**
     * @param SummaryLetterTriggerData $data
     * @return int
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function triggerLetter(SummaryLetterTriggerData $data): int
    {
        $completedRows = $this->appointmentSummaryRepository->getCompletedByPatient($this->getStepId(), $data->patientId);
        if ($completedRows > 0) {
            return parent::triggerLetter($data);
        }
        return 0;
    }

    abstract protected function getStepId(): int;
}
