<?php

namespace Tests\Unit\Services\Auth;

use Carbon\Carbon;
use DentalSleepSolutions\Services\Auth\PasswordResetDataSetter;
use Tests\TestCases\UnitTestCase;

class PasswordResetDataSetterTest extends UnitTestCase
{
    /** @var PasswordResetDataSetter */
    private $passwordResetDataSetter;

    public function setUp()
    {
        $this->passwordResetDataSetter = new PasswordResetDataSetter();
    }

    public function testPasswordReset()
    {
        $patientId = 1;
        $email = 'john@doe.com';
        $accessType = 1;
        $hash = 'foo';
        $isEmailChanged = false;
        $newPatientData = $this->passwordResetDataSetter->setPasswordResetData(
            $patientId, $email, $accessType, $hash, $isEmailChanged
        );
        $this->assertEquals($accessType, $newPatientData['access_type']);
        $this->assertEquals(1, $newPatientData['registration_status']);
        $this->assertInstanceOf(Carbon::class, $newPatientData['registration_senton']);
        $this->assertEquals($hash, $newPatientData['recover_hash']);
        $this->assertArrayNotHasKey('text_num', $newPatientData);
    }

    public function testPasswordResetWithoutHash()
    {
        $patientId = 1;
        $email = 'john@doe.com';
        $accessType = 1;
        $hash = '';
        $isEmailChanged = false;
        $newPatientData = $this->passwordResetDataSetter->setPasswordResetData(
            $patientId, $email, $accessType, $hash, $isEmailChanged
        );
        $this->assertEquals($accessType, $newPatientData['access_type']);
        $this->assertEquals(1, $newPatientData['registration_status']);
        $this->assertNotEquals($hash, $newPatientData['recover_hash']);
        $this->assertInstanceOf(Carbon::class, $newPatientData['text_date']);
        $this->assertInstanceOf(Carbon::class, $newPatientData['recover_time']);
        $this->assertEquals(0, $newPatientData['text_num']);
        $this->assertRegExp('/\d{6}/', $newPatientData['access_code']);
    }

    public function testPasswordResetWithEmailChange()
    {
        $patientId = 1;
        $email = 'john@doe.com';
        $accessType = 1;
        $hash = 'foo';
        $isEmailChanged = true;
        $newPatientData = $this->passwordResetDataSetter->setPasswordResetData(
            $patientId, $email, $accessType, $hash, $isEmailChanged
        );
        $this->assertEquals($accessType, $newPatientData['access_type']);
        $this->assertEquals(1, $newPatientData['registration_status']);
        $this->assertNotEquals($hash, $newPatientData['recover_hash']);
        $this->assertInstanceOf(Carbon::class, $newPatientData['text_date']);
        $this->assertInstanceOf(Carbon::class, $newPatientData['recover_time']);
        $this->assertEquals(0, $newPatientData['text_num']);
        $this->assertRegExp('/\d{6}/', $newPatientData['access_code']);
    }
}
