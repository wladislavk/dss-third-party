<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Helpers\UniqueLoginGenerator;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class UniqueLoginGeneratorTest extends UnitTestCase
{
    /** @var Patient|null */
    private $similarLogin;

    /** @var UniqueLoginGenerator */
    private $uniqueLoginGenerator;

    public function setUp()
    {
        $patientModel = $this->mockPatientModel();
        $this->uniqueLoginGenerator = new UniqueLoginGenerator($patientModel);
    }

    public function testWithSimilarPatientLogin()
    {
        $this->similarLogin = new Patient();
        $this->similarLogin->login = 'jdoe2';
        $firstName = 'John';
        $lastName = 'Doe';
        $uniqueLogin = $this->uniqueLoginGenerator->generateUniquePatientLogin($firstName, $lastName);
        $this->assertEquals('jdoe3', $uniqueLogin);
    }

    public function testWithoutSimilarPatientLogin()
    {
        $this->similarLogin = null;
        $firstName = 'John';
        $lastName = 'Doe';
        $uniqueLogin = $this->uniqueLoginGenerator->generateUniquePatientLogin($firstName, $lastName);
        $this->assertEquals('jdoe', $uniqueLogin);
    }

    public function testWithoutFirstName()
    {
        $this->similarLogin = null;
        $firstName = '';
        $lastName = 'Doe';
        $uniqueLogin = $this->uniqueLoginGenerator->generateUniquePatientLogin($firstName, $lastName);
        $this->assertEquals('doe', $uniqueLogin);
    }

    private function mockPatientModel()
    {
        /** @var Patient|MockInterface $patientModel */
        $patientModel = \Mockery::mock(Patient::class);
        $patientModel->shouldReceive('getSimilarPatientLogin')
            ->andReturnUsing([$this, 'getSimilarPatientLoginCallback']);
        return $patientModel;
    }

    public function getSimilarPatientLoginCallback()
    {
        return $this->similarLogin;
    }
}
