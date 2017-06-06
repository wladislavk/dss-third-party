<?php

namespace Tests\Unit\Helpers\PatientEditors;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Helpers\PasswordGenerator;
use DentalSleepSolutions\Helpers\PatientEditors\PatientCreator;
use DentalSleepSolutions\Helpers\PatientSummaryManager;
use DentalSleepSolutions\Helpers\SimilarHelper;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;
use DentalSleepSolutions\Structs\PatientName;
use Mockery\MockInterface;
use Tests\TestCases\PatientEditorTestCase;

class PatientCreatorTest extends PatientEditorTestCase
{
    /** @var array */
    private $newFormData = [];

    private $summary = [];

    /** @var Patient[] */
    private $similarPatients = [];

    /** @var int */
    private $newId = 10;

    /** @var PatientCreator */
    private $patientCreator;

    public function setUp()
    {
        $registrationEmailSender = $this->mockRegistrationEmailSender();
        $letterTriggerLauncher = $this->mockLetterTriggerLauncher();
        $patientSummaryManager = $this->mockPatientSummaryManager();
        $similarHelper = $this->mockSimilarHelper();
        $passwordGenerator = $this->mockPasswordGenerator();
        $patientModel = $this->mockPatientModel();
        $this->patientCreator = new PatientCreator(
            $registrationEmailSender,
            $letterTriggerLauncher,
            $patientSummaryManager,
            $similarHelper,
            $passwordGenerator,
            $patientModel
        );
    }

    public function testCreatePatient()
    {
        $requestData = new EditPatientRequestData();
        $requestData->ssn = 123;
        $requestData->ip = '127.0.0.1';
        $patientName = new PatientName();
        $patientName->firstName = 'John';
        $patientName->lastName = 'Doe';
        $requestData->patientName = $patientName;
        $requestData->patientLocation = 5;
        $formData = ['foo' => 'bar'];
        $user = new User();
        $responseData = $this->patientCreator->editPatient($formData, $user, $requestData);
        $this->assertEquals($this->newId, $responseData->currentPatientId);
        $status = sprintf(EditPatientResponseData::PATIENT_ADDED_STATUS, 'John Doe');
        $this->assertEquals($status, $responseData->status);
        $this->assertNull($responseData->redirectTo);
        $summary = [
            'id' => $this->newId,
            'location' => 5,
        ];
        $this->assertEquals($summary, $this->summary);
        $newFormData = [
            'foo' => 'bar',
            'password' => '123',
            'ip_address' => '127.0.0.1',
            'salt' => '',
            'userid' => 0,
            'docid' => 0,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'middlename' => '',
        ];
        $this->assertEquals($newFormData, $this->newFormData);
    }

    public function testWithoutSSN()
    {
        $requestData = new EditPatientRequestData();
        $requestData->ip = '127.0.0.1';
        $patientName = new PatientName();
        $patientName->firstName = 'John';
        $patientName->lastName = 'Doe';
        $requestData->patientName = $patientName;
        $requestData->patientLocation = 5;
        $formData = ['foo' => 'bar'];
        $user = new User();
        $this->patientCreator->editPatient($formData, $user, $requestData);
        $newFormData = [
            'foo' => 'bar',
            'password' => '',
            'ip_address' => '127.0.0.1',
            'salt' => '',
            'userid' => 0,
            'docid' => 0,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'middlename' => '',
        ];
        $this->assertEquals($newFormData, $this->newFormData);
    }

    public function testWithSimilarPatients()
    {
        $patient1 = new Patient();
        $this->similarPatients = [$patient1];
        $requestData = new EditPatientRequestData();
        $requestData->ip = '127.0.0.1';
        $patientName = new PatientName();
        $patientName->firstName = 'John';
        $patientName->lastName = 'Doe';
        $requestData->patientName = $patientName;
        $requestData->patientLocation = 5;
        $formData = ['foo' => 'bar'];
        $user = new User();
        $responseData = $this->patientCreator->editPatient($formData, $user, $requestData);
        $this->assertNull($responseData->status);
        $redirect = PatientCreator::DUPLICATE_URL . $this->newId;
        $this->assertEquals($redirect, $responseData->redirectTo);
    }

    private function mockSimilarHelper()
    {
        /** @var SimilarHelper|MockInterface $similarHelper */
        $similarHelper = \Mockery::mock(SimilarHelper::class);
        $similarHelper->shouldReceive('getSimilarPatients')
            ->andReturnUsing([$this, 'getSimilarPatientsCallback']);
        return $similarHelper;
    }

    private function mockPasswordGenerator()
    {
        /** @var PasswordGenerator|MockInterface $passwordGenerator */
        $passwordGenerator = \Mockery::mock(PasswordGenerator::class);
        $passwordGenerator->shouldReceive('generatePassword')
            ->andReturnUsing([$this, 'generatePasswordCallback']);
        return $passwordGenerator;
    }

    private function mockPatientModel()
    {
        /** @var Patient|MockInterface $patientModel */
        $patientModel = \Mockery::mock(Patient::class);
        $patientModel->shouldReceive('create')
            ->andReturnUsing([$this, 'createPatientCallback']);
        return $patientModel;
    }

    protected function mockPatientSummaryManager()
    {
        /** @var PatientSummaryManager|MockInterface $patientSummaryManager */
        $patientSummaryManager = parent::mockPatientSummaryManager();
        $patientSummaryManager->shouldReceive('createSummary')
            ->andReturnUsing([$this, 'createSummaryCallback']);
        return $patientSummaryManager;
    }

    public function generatePasswordCallback($ssn, NewPatientFormData $formData)
    {
        $formData->password = '' . $ssn;
    }

    public function createSummaryCallback($patientId, $patientLocation)
    {
        $this->summary = [
            'id' => $patientId,
            'location' => $patientLocation,
        ];
    }

    public function getSimilarPatientsCallback()
    {
        return $this->similarPatients;
    }

    public function createPatientCallback(array $formData)
    {
        $this->newFormData = $formData;
        return $this->newId;
    }
}
