<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Factories\RequestWithRulesFactory;
use DentalSleepSolutions\Helpers\PatientRuleRetriever;
use DentalSleepSolutions\Http\Requests\PatientStore;
use DentalSleepSolutions\Http\Requests\PatientUpdate;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PatientRuleRetrieverTest extends UnitTestCase
{
    /** @var PatientRuleRetriever */
    private $patientRuleRetriever;

    public function setUp()
    {
        $factory = $this->mockRequestWithRulesFactory();
        $this->patientRuleRetriever = new PatientRuleRetriever($factory);
    }

    public function testGetRulesWithPatientId()
    {
        $patientId = 1;
        $rules = $this->patientRuleRetriever->getValidationRules($patientId);
        $updateRequest = new PatientUpdate();
        $this->assertEquals($updateRequest->rules(), $rules);
    }

    public function testGetRulesWithoutPatientId()
    {
        $patientId = 0;
        $rules = $this->patientRuleRetriever->getValidationRules($patientId);
        $storeRequest = new PatientStore();
        $this->assertEquals($storeRequest->rules(), $rules);
    }

    private function mockRequestWithRulesFactory()
    {
        /** @var RequestWithRulesFactory|MockInterface $factory */
        $factory = \Mockery::mock(RequestWithRulesFactory::class);
        $factory->shouldReceive('getRequestClass')
            ->andReturnUsing([$this, 'getRequestClassCallback']);
        return $factory;
    }

    public function getRequestClassCallback($type)
    {
        $className = RequestWithRulesFactory::REQUESTS[$type];
        return new $className();
    }
}
