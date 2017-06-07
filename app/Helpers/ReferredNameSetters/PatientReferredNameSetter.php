<?php

namespace DentalSleepSolutions\Helpers\ReferredNameSetters;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Helpers\NameSetter;

class PatientReferredNameSetter extends AbstractReferredNameSetter
{
    /** @var Patient */
    private $patientModel;

    public function __construct(NameSetter $nameSetter, Patient $patientModel)
    {
        parent::__construct($nameSetter);
        $this->patientModel = $patientModel;
    }

    /**
     * @param Patient $foundPatient
     * @return Patient|null
     */
    protected function getModel(Patient $foundPatient)
    {
        $fields = ['lastname', 'firstname', 'middlename'];
        $referredPatients = $this->patientModel
            ->getWithFilter($fields, ['patientid' => $foundPatient->referred_by]);
        if (!isset($referredPatients[0])) {
            return null;
        }
        return $referredPatients[0];
    }
}
