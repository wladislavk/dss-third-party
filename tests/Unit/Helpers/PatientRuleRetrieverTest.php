<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\PatientRuleRetriever;
use DentalSleepSolutions\Http\Requests\Patient as PatientRequest;
use Tests\TestCases\UnitTestCase;

class PatientRuleRetrieverTest extends UnitTestCase
{
    /** @var PatientRuleRetriever */
    private $patientRuleRetriever;

    public function setUp()
    {
        $this->patientRuleRetriever = new PatientRuleRetriever();
    }

    public function testGetRulesWithPatientId()
    {
        $patientId = 1;
        $rules = $this->patientRuleRetriever->getValidationRules($patientId);
        $updateRequest = new PatientRequest();
        $this->assertEquals($updateRequest->updateRules(), $rules);
    }

    public function testGetRulesWithoutPatientId()
    {
        $patientId = 0;
        $rules = $this->patientRuleRetriever->getValidationRules($patientId);
        $storeRequest = new PatientRequest();
        $this->assertEquals($storeRequest->storeRules(), $rules);
    }
}
