<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\UniqueLoginGenerator;
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
        $patientRepository = $this->mockPatientRepository();
        $this->uniqueLoginGenerator = new UniqueLoginGenerator($patientRepository);
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

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('getSimilarPatientLogin')
            ->andReturnUsing([$this, 'getSimilarPatientLoginCallback']);
        return $patientRepository;
    }

    public function getSimilarPatientLoginCallback()
    {
        return $this->similarLogin;
    }
}
