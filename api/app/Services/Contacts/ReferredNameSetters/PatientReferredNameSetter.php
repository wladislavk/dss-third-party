<?php

namespace DentalSleepSolutions\Services\Contacts\ReferredNameSetters;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\Contacts\NameSetter;

class PatientReferredNameSetter extends AbstractReferredNameSetter
{
    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(NameSetter $nameSetter, PatientRepository $patientRepository)
    {
        parent::__construct($nameSetter);
        $this->patientRepository = $patientRepository;
    }

    /**
     * @param Patient $foundPatient
     * @return Patient|null
     */
    protected function getModel(Patient $foundPatient)
    {
        $fields = ['lastname', 'firstname', 'middlename'];
        $referredPatients = $this->patientRepository
            ->getWithFilter($fields, ['patientid' => $foundPatient->referred_by]);
        if (!isset($referredPatients[0])) {
            return null;
        }
        return $referredPatients[0];
    }
}
