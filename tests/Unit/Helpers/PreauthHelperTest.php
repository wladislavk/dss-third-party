<?php

namespace Tests\Unit\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\SummSleeplab;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\SummSleeplabRepository;
use DentalSleepSolutions\Helpers\PreauthHelper;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PreauthHelperTest extends UnitTestCase
{
    /** @var PreauthHelper */
    private $preauthHelper;

    public function setUp()
    {
        $patientRepository = $this->mockPatientRepository();
        $summSleeplabRepository = $this->mockSummSleeplabRepository();
        $this->preauthHelper = new PreauthHelper($patientRepository, $summSleeplabRepository);
    }

    public function testWithSleepStudy()
    {
        $patientId = 1;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVerificationOfBenefits($patientId, $userId);
        $this->assertInstanceOf(InsurancePreauth::class, $newInsurancePreauth);
        $this->assertEquals(1, $newInsurancePreauth->patient_id);
        $this->assertEquals('foo', $newInsurancePreauth->diagnosis_code);
        $this->assertInstanceOf(Carbon::class, $newInsurancePreauth->front_office_request_date);
        $this->assertEquals(PreauthHelper::DSS_PREAUTH_PENDING, $newInsurancePreauth->status);
        $this->assertEquals(1, $newInsurancePreauth->userid);
        $this->assertEquals(1, $newInsurancePreauth->viewed);
    }

    public function testWithoutSleepStudy()
    {
        $patientId = 2;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVerificationOfBenefits($patientId, $userId);
        $this->assertInstanceOf(InsurancePreauth::class, $newInsurancePreauth);
        $this->assertEquals('', $newInsurancePreauth->diagnosis_code);
    }

    public function testWithoutPreauthInfo()
    {
        $patientId = 3;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVerificationOfBenefits($patientId, $userId);
        $this->assertNull($newInsurancePreauth);
    }

    public function testWithoutTransactionCode()
    {
        $patientId = 4;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVerificationOfBenefits($patientId, $userId);
        $this->assertNull($newInsurancePreauth);
    }

    public function testWithoutUserInfo()
    {
        $patientId = 5;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVerificationOfBenefits($patientId, $userId);
        $this->assertNull($newInsurancePreauth);
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('getDentalDeviceTransactionCode')
            ->andReturnUsing([$this, 'getDentalDeviceTransactionCodeCallback']);
        $patientRepository->shouldReceive('getUserInfo')
            ->andReturnUsing([$this, 'getUserInfoCallback']);
        $patientRepository->shouldReceive('getInsurancePreauthInfo')
            ->andReturnUsing([$this, 'getInsurancePreauthInfoCallback']);
        return $patientRepository;
    }

    private function mockSummSleeplabRepository()
    {
        /** @var SummSleeplabRepository|MockInterface $summSleeplabRepository */
        $summSleeplabRepository = \Mockery::mock(SummSleeplabRepository::class);
        $summSleeplabRepository->shouldReceive('getPatientDiagnosis')
            ->andReturnUsing([$this, 'getPatientDiagnosisCallback']);
        return $summSleeplabRepository;
    }

    public function getDentalDeviceTransactionCodeCallback($patientId)
    {
        if ($patientId < 4) {
            return new Patient();
        }
        return null;
    }

    public function getUserInfoCallback($patientId)
    {
        if ($patientId < 5) {
            return new User();
        }
        return null;
    }

    public function getInsurancePreauthInfoCallback($patientId)
    {
        if ($patientId < 3) {
            return new Patient();
        }
        return null;
    }

    public function getPatientDiagnosisCallback($patientId)
    {
        if ($patientId < 2) {
            $result = new SummSleeplab();
            $result->diagnosis = 'foo';
            return $result;
        }
        return null;
    }
}
