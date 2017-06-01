<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\User;

class PatientPortalRetriever
{
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
        $docInfo = $this->userModel->getWithFilter('use_patient_portal', ['userid' => $docId]);
        // TODO: check if first() should be used
        if (!isset($docInfo[0])) {
            return false;
        }
        $docPatientPortal = $docInfo[0]->use_patient_portal;
        if ($docPatientPortal && $usePatientPortal) {
            return true;
        }
        return false;
    }
}
