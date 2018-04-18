<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Http\Requests\Patient as PatientRequest;

/**
 * @todo: If requests were handled properly in the controller, this class would not be needed
 */
class PatientRuleRetriever
{
    /**
     * @param int $patientId
     * @return array
     */
    public function getValidationRules($patientId)
    {
        $request = new PatientRequest();
        if ($patientId) {
            return $request->updateRules();
        }
        return $request->storeRules();
    }
}
