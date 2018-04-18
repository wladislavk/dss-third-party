<?php

namespace Tests\Unit\Services\PatientEditors;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\PasswordGenerator;
use DentalSleepSolutions\Services\PatientEditors\PatientCreator;
use DentalSleepSolutions\Services\PatientSummaryManager;
use DentalSleepSolutions\Services\SimilarHelper;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;
use DentalSleepSolutions\Structs\PatientName;
use Mockery\MockInterface;
use Tests\TestCases\PatientEditorTestCase;

class PatientCreatorTest extends PatientEditorTestCase
{
    /** @var Patient */
    private $newFormData;

    private $summary = [];

    /** @var Patient[] */
    private $similarPatients = [];

    /** @var PatientCreator */
    private $patientCreator;

    public function setUp()
    {
        $registrationEmailSender = $this->mockRegistrationEmailSender();
        $letterTriggerLauncher = $this->mockLetterTriggerLauncher();
        $patientSummaryManager = $this->mockPatientSummaryManager();
        $similarHelper = $this->mockSimilarHelper();
        $passwordGenerator = $this->mockPasswordGenerator();
        $patientRepository = $this->mockPatientRepository();
        $this->patientCreator = new PatientCreator(
            $registrationEmailSender,
            $letterTriggerLauncher,
            $patientSummaryManager,
            $similarHelper,
            $passwordGenerator,
            $patientRepository
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
        $this->assertEquals(1, $responseData->currentPatientId);
        $status = sprintf(EditPatientResponseData::PATIENT_ADDED_STATUS, 'John Doe');
        $this->assertEquals($status, $responseData->status);
        $this->assertNull($responseData->redirectTo);
        $summary = [
            'id' => 1,
            'location' => 5,
        ];
        $this->assertEquals($summary, $this->summary);
        $this->assertEquals('bar', $this->newFormData->foo);
        $this->assertEquals('123', $this->newFormData->password);
        $this->assertEquals('127.0.0.1', $this->newFormData->ip_address);
        $this->assertEquals(0, $this->newFormData->userid);
        $this->assertEquals(0, $this->newFormData->docid);
        $this->assertEquals('John', $this->newFormData->firstname);
        $this->assertEquals('Doe', $this->newFormData->lastname);
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
        $this->assertEquals('bar', $this->newFormData->foo);
        $this->assertEquals('', $this->newFormData->password);
        $this->assertEquals('127.0.0.1', $this->newFormData->ip_address);
        $this->assertEquals(0, $this->newFormData->userid);
        $this->assertEquals(0, $this->newFormData->docid);
        $this->assertEquals('John', $this->newFormData->firstname);
        $this->assertEquals('Doe', $this->newFormData->lastname);
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
        $redirect = PatientCreator::DUPLICATE_URL . 1;
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
        $passwordGenerator->shouldReceive('generateLegacyPassword')
            ->andReturnUsing([$this, 'generatePasswordCallback']);
        return $passwordGenerator;
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('create')
            ->andReturnUsing([$this, 'createPatientCallback']);
        return $patientRepository;
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
        $this->newFormData = new Patient();
        $this->newFormData->patientid = 1;
        $this->newFormData->foo = 'bar';
        $this->newFormData->password = $formData['password'];
        $this->newFormData->salt = '';
        $this->newFormData->ip_address = '127.0.0.1';
        $this->newFormData->userid = 0;
        $this->newFormData->docid = 0;
        $this->newFormData->firstname = 'John';
        $this->newFormData->lastname = 'Doe';
        $this->newFormData->middlename = '';
        return $this->newFormData;
    }
}
