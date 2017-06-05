<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Factories\RequestWithRulesFactory;

class PatientRuleRetriever
{
    /** @var RequestWithRulesFactory */
    private $requestWithRulesFactory;

    public function __construct(RequestWithRulesFactory $requestWithRulesFactory)
    {
        $this->requestWithRulesFactory = $requestWithRulesFactory;
    }

    /**
     * @param int $patientId
     * @return array
     */
    public function getValidationRules($patientId)
    {
        $type = RequestWithRulesFactory::PATIENT_STORE;
        if ($patientId) {
            $type = RequestWithRulesFactory::PATIENT_UPDATE;
        }
        $requestClass = $this->requestWithRulesFactory->getRequestClass($type);
        return $requestClass->rules();
    }
}
