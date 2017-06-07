<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Summary;
use DentalSleepSolutions\Helpers\PatientLocationRetriever;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PatientLocationRetrieverTest extends UnitTestCase
{
    /** @var PatientLocationRetriever */
    private $patientLocationRetriever;

    public function setUp()
    {
        $summaryModel = $this->mockSummaryModel();
        $this->patientLocationRetriever = new PatientLocationRetriever($summaryModel);
    }

    public function testGetLocation()
    {
        $patientId = 1;
        $patientLocation = $this->patientLocationRetriever->getPatientLocation($patientId);
        $this->assertEquals(2, $patientLocation);
    }

    public function testWithoutLocations()
    {
        $patientId = 2;
        $patientLocation = $this->patientLocationRetriever->getPatientLocation($patientId);
        $this->assertEquals(0, $patientLocation);
    }

    private function mockSummaryModel()
    {
        /** @var Summary|MockInterface $summaryModel */
        $summaryModel = \Mockery::mock(Summary::class);
        $summaryModel->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getSummaryWithFilterCallback']);
        return $summaryModel;
    }

    public function getSummaryWithFilterCallback(array $fields, array $where)
    {
        if ($where['patientid'] == 1) {
            $summary1 = new Summary();
            $summary1->location = 2;
            $summary2 = new Summary();
            $summary2->location = 3;
            return [$summary1, $summary2];
        }
        return [];
    }
}
