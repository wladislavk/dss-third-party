<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\User;

class PatientPortalRetriever
{
    const FIELDS = [
        'use_patient_portal',
    ];

    /** @var User */
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
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
        $docInfo = $this->userModel->getWithFilter(self::FIELDS, ['userid' => $docId]);
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
