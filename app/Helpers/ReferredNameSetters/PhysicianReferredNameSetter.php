<?php

namespace DentalSleepSolutions\Helpers\ReferredNameSetters;

use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Helpers\NameSetter;

class PhysicianReferredNameSetter extends AbstractReferredNameSetter
{
    /** @var Contact */
    private $contactModel;

    public function __construct(NameSetter $nameSetter, Contact $contactModel)
    {
        parent::__construct($nameSetter);
        $this->contactModel = $contactModel;
    }

    /**
     * @param Patient $foundPatient
     * @return Contact|null
     */
    protected function getModel(Patient $foundPatient)
    {
        return $this->contactModel->getDocShortInfo($foundPatient->referred_by);
    }
}
