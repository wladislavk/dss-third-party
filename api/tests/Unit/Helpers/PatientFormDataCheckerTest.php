<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\PatientFormDataChecker;
use Tests\TestCases\UnitTestCase;

class PatientFormDataCheckerTest extends UnitTestCase
{
    /** @var array */
    private $formData = [];

    /** @var PatientFormDataChecker */
    private $patientFormDataChecker;

    public function setUp()
    {
        $this->formData = [
            'add1' => 'some address',
            'city' => 'some city',
            'state' => 'some state',
            'zip' => 'some zip',
            'dob' => 'some dob',
            'gender' => 'who knows',
        ];
        $this->patientFormDataChecker = new PatientFormDataChecker();
    }

    public function testWithEmail()
    {
        $this->formData['email'] = 'foo@bar.com';
        $isComplete = $this->patientFormDataChecker->isInfoComplete($this->formData);
        $this->assertTrue($isComplete);
    }

    public function testWithPhone()
    {
        $this->formData['home_phone'] = '223322';
        $isComplete = $this->patientFormDataChecker->isInfoComplete($this->formData);
        $this->assertTrue($isComplete);
    }

    public function testWithoutEmailAndPhone()
    {
        $isComplete = $this->patientFormDataChecker->isInfoComplete($this->formData);
        $this->assertFalse($isComplete);
    }

    public function testWithoutMandatoryKey()
    {
        $this->formData['work_phone'] = '223322';
        unset($this->formData['city']);
        $isComplete = $this->patientFormDataChecker->isInfoComplete($this->formData);
        $this->assertFalse($isComplete);
    }
}
