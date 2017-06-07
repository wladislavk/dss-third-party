<?php

namespace Tests\Unit\Helpers\ReferredNameSetters;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Helpers\NameSetter;
use DentalSleepSolutions\Helpers\ReferredNameSetters\PatientReferredNameSetter;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PatientReferredNameSetterTest extends UnitTestCase
{
    /** @var Patient */
    private $referredPatient;

    /** @var PatientReferredNameSetter */
    private $patientReferredNameSetter;

    public function setUp()
    {
        $this->referredPatient = new Patient();
        $this->referredPatient->patientid = 1;
        $this->referredPatient->firstname = 'John';
        $this->referredPatient->middlename = 'Harry';
        $this->referredPatient->lastname = 'Doe';

        $nameSetter = new NameSetter();
        $patientModel = $this->mockPatientModel();
        $this->patientReferredNameSetter = new PatientReferredNameSetter($nameSetter, $patientModel);
    }

    public function testWithPatients()
    {
        $foundPatient = new Patient();
        $foundPatient->referred_by = 1;
        $name = $this->patientReferredNameSetter->setReferredName($foundPatient);
        $this->assertEquals('Doe, John Harry - Patient', $name);
    }

    public function testWithoutPatients()
    {
        $foundPatient = new Patient();
        $foundPatient->referred_by = 2;
        $name = $this->patientReferredNameSetter->setReferredName($foundPatient);
        $this->assertNull($name);
    }

    private function mockPatientModel()
    {
        /** @var Patient|MockInterface $patientModel */
        $patientModel = \Mockery::mock(Patient::class);
        $patientModel->shouldReceive('getWithFilter')
            ->andReturnUsing([$this, 'getWithFilterCallback']);
        return $patientModel;
    }

    public function getWithFilterCallback(array $fields, array $where)
    {
        if ($where['patientid'] == $this->referredPatient->patientid) {
            return [$this->referredPatient];
        }
        return [];
    }
}
