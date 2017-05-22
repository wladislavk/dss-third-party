<?php

namespace Tests\Unit\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\SummSleeplab;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Helpers\PreauthHelper;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class PreauthHelperTest extends UnitTestCase
{
    /** @var PreauthHelper */
    private $preauthHelper;

    public function setUp()
    {
        $patientModel = $this->mockPatientModel();
        $summSleeplabModel = $this->mockSummSleeplabModel();
        $this->preauthHelper = new PreauthHelper($patientModel, $summSleeplabModel);
    }

    public function testWithSleepStudy()
    {
        $patientId = 1;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVob($patientId, $userId);
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
        $newInsurancePreauth = $this->preauthHelper->createVob($patientId, $userId);
        $this->assertInstanceOf(InsurancePreauth::class, $newInsurancePreauth);
        $this->assertEquals('', $newInsurancePreauth->diagnosis_code);
    }

    public function testWithoutPreauthInfo()
    {
        $patientId = 3;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVob($patientId, $userId);
        $this->assertNull($newInsurancePreauth);
    }

    public function testWithoutTransactionCode()
    {
        $patientId = 4;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVob($patientId, $userId);
        $this->assertNull($newInsurancePreauth);
    }

    public function testWithoutUserInfo()
    {
        $patientId = 5;
        $userId = 1;
        $newInsurancePreauth = $this->preauthHelper->createVob($patientId, $userId);
        $this->assertNull($newInsurancePreauth);
    }

    private function mockPatientModel()
    {
        /** @var Patient|MockInterface $patientModel */
        $patientModel = \Mockery::mock(Patient::class);
        $patientModel->shouldReceive('getDentalDeviceTransactionCode')
            ->andReturnUsing([$this, 'getDentalDeviceTransactionCodeCallback']);
        $patientModel->shouldReceive('getUserInfo')
            ->andReturnUsing([$this, 'getUserInfoCallback']);
        $patientModel->shouldReceive('getInsurancePreauthInfo')
            ->andReturnUsing([$this, 'getInsurancePreauthInfoCallback']);
        return $patientModel;
    }

    private function mockSummSleeplabModel()
    {
        /** @var SummSleeplab|MockInterface $summSleeplabModel */
        $summSleeplabModel = \Mockery::mock(SummSleeplab::class);
        $summSleeplabModel->shouldReceive('getPatientDiagnosis')
            ->andReturnUsing([$this, 'getPatientDiagnosisCallback']);
        return $summSleeplabModel;
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
