<?php

namespace Tests\Unit\Services\Patients;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\Patients\SimilarHelper;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class SimilarHelperTest extends UnitTestCase
{
    /** @var array */
    private $patientInfo;

    /** @var array */
    private $expectedResult = [];

    /** @var SimilarHelper */
    private $similarHelper;

    public function setUp()
    {
        $this->expectedResult = [
            [
                'id' => 10,
                'name' => 'John Doe',
                'address' => 'address1 address2 223322',
            ],
            [
                'id' => 11,
                'name' => 'Jane Jones',
                'address' => 'address3 LA California',
            ],
        ];

        $patientRepository = $this->mockPatientRepository();
        $this->similarHelper = new SimilarHelper($patientRepository);
    }

    public function testWithoutFoundPatient()
    {
        $patientId = 1;
        $docId = 1;
        $docs = $this->similarHelper->getSimilarPatients($patientId, $docId);
        $this->assertEquals($this->expectedResult, $docs);
        $this->assertEquals([], $this->patientInfo);
    }

    public function testWithFoundPatient()
    {
        $patientId = 2;
        $docId = 1;
        $docs = $this->similarHelper->getSimilarPatients($patientId, $docId);
        $this->assertEquals($this->expectedResult, $docs);
        $expectedPatientInfo = [
            'patient_id' => 2,
            'firstname' => 'Harry',
            'lastname' => 'Truman',
            'add1' => 'address1',
            'city' => 'NYC',
            'state' => 'NY',
            'zip' => '10100',
        ];
        $this->assertEquals($expectedPatientInfo, $this->patientInfo);
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('find')
            ->andReturnUsing([$this, 'findPatientCallback']);
        $patientRepository->shouldReceive('getSimilarPatients')
            ->andReturnUsing([$this, 'getSimilarPatientsCallback']);
        return $patientRepository;
    }

    public function findPatientCallback($patientId)
    {
        if ($patientId == 2) {
            $patient = new Patient();
            $patient->patientid = 2;
            $patient->firstname = 'Harry';
            $patient->lastname = 'Truman';
            $patient->add1 = 'address1';
            $patient->city = 'NYC';
            $patient->state = 'NY';
            $patient->zip = '10100';
            return $patient;
        }
        return null;
    }

    public function getSimilarPatientsCallback($docId, array $patientInfo)
    {
        $this->patientInfo = $patientInfo;
        $patient1 = new Patient();
        $patient1->patientid = 10;
        $patient1->firstname = 'John';
        $patient1->lastname = 'Doe';
        $patient1->add1 = 'address1';
        $patient1->add2 = 'address2';
        $patient1->zip = '223322';
        $patient2 = new Patient();
        $patient2->patientid = 11;
        $patient2->firstname = 'Jane';
        $patient2->lastname = 'Jones';
        $patient2->add1 = 'address3';
        $patient2->city = 'LA';
        $patient2->state = 'California';
        return [$patient1, $patient2];
    }
}
