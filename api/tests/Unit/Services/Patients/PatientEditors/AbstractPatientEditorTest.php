<?php

namespace Tests\Unit\Services\Patients\PatientEditors;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use Tests\Dummies\DummyPatientEditor;
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
        $userRepository = $this->mockUserRepository();
        $this->patientEditor = new DummyPatientEditor(
            $registrationEmailSender, $letterTriggerLauncher, $patientSummaryManager, $userRepository
        );
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
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
            'docId' => 2,
            'userId' => 2,
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

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
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
