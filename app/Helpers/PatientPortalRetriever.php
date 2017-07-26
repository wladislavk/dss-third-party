<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\UserRepository;

class PatientPortalRetriever
{
    const FIELDS = [
        'use_patient_portal',
    ];

    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $docId
     * @param bool $usePatientPortal
     * @return bool
     */
    public function hasPatientPortal($docId, $usePatientPortal)
    {
        if (!$usePatientPortal) {
            return false;
        }
        $docInfo = $this->userRepository->getWithFilter(self::FIELDS, ['userid' => $docId]);
        // TODO: check if first() should be used
        if (!isset($docInfo[0])) {
            return false;
        }
        if (!$docInfo[0]->use_patient_portal) {
            return false;
        }
        return true;
    }
}
