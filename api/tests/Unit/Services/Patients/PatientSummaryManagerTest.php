<?php

namespace Tests\Unit\Services\Patients;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\Summary;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\SummaryRepository;
use DentalSleepSolutions\Services\Patients\PatientSummaryManager;
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

        $summaryRepository = $this->mockSummaryRepository();
        $patientSummaryRepository = $this->mockPatientSummaryRepository();
        $this->patientSummaryManager = new PatientSummaryManager($summaryRepository, $patientSummaryRepository);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
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

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testCreateSummaryWithoutLocation()
    {
        $patientId = 1;
        $patientLocation = 0;
        $this->patientSummaryManager->createSummary($patientId, $patientLocation);
        $this->assertEquals([], $this->createdSummary);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
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

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
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

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateSummaryWithoutLocation()
    {
        $patientId = 1;
        $patientLocation = 0;
        $this->patientSummaryManager->updateSummaryWithLocation($patientId, $patientLocation);
        $this->assertEquals([], $this->createdSummary);
        $this->assertEquals([], $this->updatedSummary);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
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

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
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

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testUpdatePatientSummaryWithoutId()
    {
        $patientId = 0;
        $isInfoComplete = false;
        $this->patientSummaryManager->updatePatientSummary($patientId, $isInfoComplete);
        $this->assertEquals([], $this->updatedPatientSummary);
        $this->assertEquals([], $this->createdPatientSummary);
    }

    private function mockSummaryRepository()
    {
        /** @var SummaryRepository|MockInterface $summaryRepository */
        $summaryRepository = \Mockery::mock(SummaryRepository::class);
        $summaryRepository->shouldReceive('create')
            ->andReturnUsing([$this, 'createSummaryCallback']);
        $summaryRepository->shouldReceive('updateForPatient')
            ->andReturnUsing([$this, 'updateSummaryForPatientCallback']);
        $summaryRepository->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getSummaryWithFilterCallback']);
        return $summaryRepository;
    }

    private function mockPatientSummaryRepository()
    {
        /** @var PatientSummaryRepository|MockInterface $patientSummaryRepository */
        $patientSummaryRepository = \Mockery::mock(PatientSummaryRepository::class);
        $patientSummaryRepository->shouldReceive('findOrNull')
            ->andReturnUsing([$this, 'findPatientSummaryCallback']);
        $patientSummaryRepository->shouldReceive('create')
            ->andReturnUsing([$this, 'createPatientSummaryCallback']);
        $patientSummaryRepository->shouldReceive('update')
            ->andReturnUsing([$this, 'updatePatientSummaryCallback']);
        return $patientSummaryRepository;
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

    public function updatePatientSummaryCallback(array $data, $id)
    {
        $this->updatedPatientSummary = array_merge(['id' => $id], $data);
    }
}
