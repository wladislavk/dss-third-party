<?php

namespace Tests\Unit\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\SummSleeplab;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\SummarySleeplabRepository;
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
        $expected = [
            'patient_id' => 1,
            'diagnosis_code' => 'foo',
            'front_office_request_date' => Carbon::now(),
            'status' => PreauthHelper::DSS_PREAUTH_PENDING,
            'userid' => 1,
            'viewed' => 1,
        ];
        $this->assertEquals($expected, $newInsurancePreauth);
    }

    public function testWithoutSleepStudy()
    {
        $patientId = 2;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVerificationOfBenefits($patientId, $userId);
        $expected = [
            'patient_id' => 2,
            'diagnosis_code' => '',
            'front_office_request_date' => Carbon::now(),
            'status' => PreauthHelper::DSS_PREAUTH_PENDING,
            'userid' => 1,
            'viewed' => 1,
        ];
        $this->assertEquals($expected, $newInsurancePreauth);
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
        /** @var SummarySleeplabRepository|MockInterface $summSleeplabRepository */
        $summSleeplabRepository = \Mockery::mock(SummarySleeplabRepository::class);
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
