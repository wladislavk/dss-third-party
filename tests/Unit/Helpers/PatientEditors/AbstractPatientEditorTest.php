<?php

namespace Tests\Unit\Helpers\PatientEditors;

use DentalSleepSolutions\Dummies\DummyPatientEditor;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use Tests\TestCases\PatientEditorTestCase;

class AbstractPatientEditorTest extends PatientEditorTestCase
{
    /** @var DummyPatientEditor */
    private $patientEditor;

    public function setUp()
    {
        $registrationEmailSender = $this->mockRegistrationEmailSender();
        $letterTriggerLauncher = $this->mockLetterTriggerLauncher();
        $patientSummaryManager = $this->mockPatientSummaryManager();
        $this->patientEditor = new DummyPatientEditor(
            $registrationEmailSender, $letterTriggerLauncher, $patientSummaryManager
        );
    }

    public function testWithPatient()
    {
        $formData = ['foo' => 'bar'];
        $user = new User();
        $user->userid = 2;
        $requestData = new EditPatientRequestData();
        $patient = new Patient();
        $patient->patientid = 1;
        $responseData = $this->patientEditor->editPatient($formData, $user, $requestData, $patient);
        $this->assertInstanceOf(EditPatientResponseData::class, $responseData);
        $this->assertEquals(1, $responseData->currentPatientId);
        $this->assertTrue($this->emailSent);
        $summary = [
            'patientId' => 1,
            'isInfoComplete' => false,
        ];
        $this->assertEquals($summary, $this->updatedSummary);
        $letters = [
            'patientId' => 1,
            'docId' => 0,
            'userId' => 0,
            'userType' => 0,
        ];
        $this->assertEquals($letters, $this->triggeredLetters);
        $modifiedFormData = [
            'foo' => 'bar',
            'password'   => '',
            'salt'       => '',
            'userid'     => 0,
            'docid'      => 0,
            'ip_address' => '',
            'firstname'  => '',
            'lastname'   => '',
            'middlename' => '',
        ];
        $this->assertEquals($modifiedFormData, $this->patientEditor->modifiedFormData);
    }

    public function testWithoutPatient()
    {
        $formData = ['foo' => 'bar'];
        $user = new User();
        $user->userid = 2;
        $requestData = new EditPatientRequestData();
        $responseData = $this->patientEditor->editPatient($formData, $user, $requestData);
        $this->assertInstanceOf(EditPatientResponseData::class, $responseData);
        $this->assertEquals(0, $responseData->currentPatientId);
    }
}
