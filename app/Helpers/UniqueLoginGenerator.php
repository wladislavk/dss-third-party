<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;

class UniqueLoginGenerator
{
    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @return string
     */
    public function generateUniquePatientLogin($firstName, $lastName)
    {
        $initial = $this->getInitial($firstName);
        $uniqueLogin = strtolower($initial . $lastName);
        $similarPatientLogin = $this->patientRepository->getSimilarPatientLogin($uniqueLogin);

        if ($similarPatientLogin) {
            $number = $this->getLoginNumber($similarPatientLogin->login, $uniqueLogin);
            $number = $number + 1;
            $uniqueLogin = $uniqueLogin . $number;
        }
        return $uniqueLogin;
    }

    /**
     * @param string $firstName
     * @return string
     */
    private function getInitial($firstName)
    {
        if (!$firstName) {
            return '';
        }
        return substr($firstName, 0, 1);
    }

    /**
     * TODO: this logic does not make sense because it relies too much on how logins are formed
     *
     * @param string $compositeLogin
     * @param string $stringPart
     * @return int
     */
    private function getLoginNumber($compositeLogin, $stringPart)
    {
        return (int)str_replace($stringPart, '', $compositeLogin);
    }
}
