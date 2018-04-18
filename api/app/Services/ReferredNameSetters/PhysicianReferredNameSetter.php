<?php

namespace DentalSleepSolutions\Services\ReferredNameSetters;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Services\NameSetter;

class PhysicianReferredNameSetter extends AbstractReferredNameSetter
{
    /** @var ContactRepository */
    private $contactRepository;

    public function __construct(NameSetter $nameSetter, ContactRepository $contactRepository)
    {
        parent::__construct($nameSetter);
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param Patient $foundPatient
     * @return Contact|null
     */
    protected function getModel(Patient $foundPatient)
    {
        return $this->contactRepository->getDocShortInfo($foundPatient->referred_by);
    }
}
