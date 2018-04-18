<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\AccessCodeResetter;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class AccessCodeResetterTest extends UnitTestCase
{
    /** @var array */
    private $updatedData = [];

    /** @var AccessCodeResetter */
    private $accessCodeResetter;

    public function setUp()
    {
        $patientRepository = $this->mockPatientRepository();
        $this->accessCodeResetter = new AccessCodeResetter($patientRepository);
    }

    public function testResetAccessCode()
    {
        $patientId = 1;
        date_default_timezone_set('UTC');
        $updateData = $this->accessCodeResetter->resetAccessCode($patientId);
        $this->assertGreaterThanOrEqual(100000, $updateData['access_code']);
        $this->assertLessThanOrEqual(999999, $updateData['access_code']);
        // corresponds to Y-m-d H:i:s
        $regexp = '/\d{4}\-\d{2}\-\d{2}\s\d{2}:\d{2}:\d{2}/';
        $this->assertRegExp($regexp, $updateData['access_code_date']);
        $this->assertEquals(1, $this->updatedData['id']);
    }

    public function testWithoutPatientId()
    {
        $patientId = 0;
        $updateData = $this->accessCodeResetter->resetAccessCode($patientId);
        $expected = [
            'access_code' => 0,
            'access_code_date' => null,
        ];
        $this->assertEquals($expected, $updateData);
        $this->assertEquals([], $this->updatedData);
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('updatePatient')
            ->andReturnUsing([$this, 'updatePatientCallback']);
        return $patientRepository;
    }

    public function updatePatientCallback($id, array $data)
    {
        $this->updatedData = array_merge(['id' => $id], $data);
    }
}
