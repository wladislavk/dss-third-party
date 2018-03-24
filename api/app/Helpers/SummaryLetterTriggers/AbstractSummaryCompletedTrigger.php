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
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function triggerLetter(SummaryLetterTriggerData $data): void
    {
        if ($this->hasCompletedRows($data)) {
            parent::triggerLetter($data);
        }
    }

    protected function hasCompletedRows(SummaryLetterTriggerData $data): bool
    {
        $completedRows = $this->appointmentSummaryRepository->getCompletedByPatient($this->getStepId(), $data->patientId);
        if ($completedRows > 0) {
            return true;
        }
        return false;
    }

    abstract protected function getStepId(): int;
}
