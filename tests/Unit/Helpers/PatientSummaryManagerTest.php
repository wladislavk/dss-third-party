<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Dental\Summary;
use DentalSleepSolutions\Helpers\PatientSummaryManager;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PatientSummaryManagerTest extends UnitTestCase
{
    /** @var array */
    private $createdSummary = [];

    /** @var array */
    private $updatedSummary = [];

    /** @var array */
    private $createdPatientSummary = [];

    /** @var array */
    private $updatedPatientSummary = [];

    /** @var Summary[] */
    private $summaries = [];

    /** @var PatientSummary */
    private $patientSummary;

    /** @var PatientSummaryManager */
    private $patientSummaryManager;

    public function setUp()
    {
        $this->patientSummary = new PatientSummary();
        $this->patientSummary->pid = 1;

        $summaryModel = $this->mockSummaryModel();
        $patientSummaryModel = $this->mockPatientSummaryModel();
        $this->patientSummaryManager = new PatientSummaryManager($summaryModel, $patientSummaryModel);
    }

    public function testCreateSummary()
    {
        $patientId = 1;
        $patientLocation = 2;
        $this->patientSummaryManager->createSummary($patientId, $patientLocation);
        $expected = [
            'location'  => 2,
            'patientid' => 1,
        ];
        $this->assertEquals($expected, $this->createdSummary);
    }

    public function testCreateSummaryWithoutLocation()
    {
        $patientId = 1;
        $patientLocation = 0;
        $this->patientSummaryManager->createSummary($patientId, $patientLocation);
        $this->assertEquals([], $this->createdSummary);
    }

    public function testUpdateSummaryWithResults()
    {
        $summary1 = new Summary();
        $this->summaries[] = $summary1;
        $patientId = 1;
        $patientLocation = 2;
        $this->patientSummaryManager->updateSummaryWithLocation($patientId, $patientLocation);
        $expected = [
            'location'  => 2,
            'patientid' => 1,
        ];
        $this->assertEquals($expected, $this->updatedSummary);
        $this->assertEquals([], $this->createdSummary);
    }

    public function testUpdateSummaryWithoutResults()
    {
        $patientId = 1;
        $patientLocation = 2;
        $this->patientSummaryManager->updateSummaryWithLocation($patientId, $patientLocation);
        $expected = [
            'location'  => 2,
            'patientid' => 1,
        ];
        $this->assertEquals([], $this->updatedSummary);
        $this->assertEquals($expected, $this->createdSummary);
    }

    public function testUpdateSummaryWithoutLocation()
    {
        $patientId = 1;
        $patientLocation = 0;
        $this->patientSummaryManager->updateSummaryWithLocation($patientId, $patientLocation);
        $this->assertEquals([], $this->createdSummary);
        $this->assertEquals([], $this->updatedSummary);
    }

    public function testUpdatePatientSummaryWithResults()
    {
        $patientId = 1;
        $isInfoComplete = true;
        $this->patientSummaryManager->updatePatientSummary($patientId, $isInfoComplete);
        $expected = [
            'id' => 1,
            'patient_info' => true,
        ];
        $this->assertEquals($expected, $this->updatedPatientSummary);
        $this->assertEquals([], $this->createdPatientSummary);
    }

    public function testUpdatePatientSummaryWithoutResults()
    {
        $patientId = 2;
        $isInfoComplete = false;
        $this->patientSummaryManager->updatePatientSummary($patientId, $isInfoComplete);
        $expected = [
            'pid' => 2,
            'patient_info' => false,
        ];
        $this->assertEquals([], $this->updatedPatientSummary);
        $this->assertEquals($expected, $this->createdPatientSummary);
    }

    public function testUpdatePatientSummaryWithoutId()
    {
        $patientId = 0;
        $isInfoComplete = false;
        $this->patientSummaryManager->updatePatientSummary($patientId, $isInfoComplete);
        $this->assertEquals([], $this->updatedPatientSummary);
        $this->assertEquals([], $this->createdPatientSummary);
    }

    private function mockSummaryModel()
    {
        /** @var Summary|MockInterface $summaryModel */
        $summaryModel = \Mockery::mock(Summary::class);
        $summaryModel->shouldReceive('create')
            ->andReturnUsing([$this, 'createSummaryCallback']);
        $summaryModel->shouldReceive('updateForPatient')
            ->andReturnUsing([$this, 'updateSummaryForPatientCallback']);
        $summaryModel->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getSummaryWithFilterCallback']);
        return $summaryModel;
    }

    private function mockPatientSummaryModel()
    {
        /** @var PatientSummary|MockInterface $patientSummaryModel */
        $patientSummaryModel = \Mockery::mock(PatientSummary::class);
        $patientSummaryModel->shouldReceive('find')
            ->andReturnUsing([$this, 'findPatientSummaryCallback']);
        $patientSummaryModel->shouldReceive('create')
            ->andReturnUsing([$this, 'createPatientSummaryCallback']);
        $patientSummaryModel->shouldReceive('updateStatic')
            ->andReturnUsing([$this, 'updatePatientSummaryCallback']);
        return $patientSummaryModel;
    }

    public function createSummaryCallback(array $data)
    {
        $this->createdSummary = $data;
    }

    public function getSummaryWithFilterCallback()
    {
        return $this->summaries;
    }

    public function updateSummaryForPatientCallback($id, array $data)
    {
        $this->updatedSummary = array_merge(['patientid' => $id], $data);
    }

    public function findPatientSummaryCallback($id)
    {
        if ($id == $this->patientSummary->pid) {
            return $this->patientSummary;
        }
        return null;
    }

    public function createPatientSummaryCallback(array $data)
    {
        $this->createdPatientSummary = $data;
    }

    public function updatePatientSummaryCallback(PatientSummary $patientSummary, array $data)
    {
        $this->updatedPatientSummary = array_merge(['id' => $patientSummary->pid], $data);
    }
}
