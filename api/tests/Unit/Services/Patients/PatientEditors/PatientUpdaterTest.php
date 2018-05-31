<?php

namespace Tests\Unit\Services\Patients\PatientEditors;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Services\Letters\LetterManager;
use DentalSleepSolutions\Services\Patients\PatientEditors\PatientUpdater;
use DentalSleepSolutions\Services\Patients\PatientUpdateMailer;
use DentalSleepSolutions\Services\InsurancePreauth\PendingVOBRemover;
use DentalSleepSolutions\Structs\EditPatientMail;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\PatientReferrer;
use DentalSleepSolutions\Structs\EditPatientIntendedActions;
use Mockery\MockInterface;
use Tests\TestCases\PatientEditorTestCase;

class PatientUpdaterTest extends PatientEditorTestCase
{
    const MAIL_MESSAGE = 'my message';

    /** @var array */
    private $letters = [];

    /** @var array */
    private $updatedLocationSummary = [];

    /** @var array */
    private $pendingVOBData = [];

    /** @var PatientUpdater */
    private $patientUpdater;

    public function setUp()
    {
        $registrationEmailSender = $this->mockRegistrationEmailSender();
        $letterTriggerLauncher = $this->mockLetterTriggerLauncher();
        $patientSummaryManager = $this->mockPatientSummaryManager();
        $patientUpdateMailer = $this->mockPatientUpdateMailer();
        $letterManager = $this->mockLetterManager();
        $pendingVOBRemover = $this->mockPendingVOBRemover();
        $userRepository = $this->mockUserRepository();
        $this->patientUpdater = new PatientUpdater(
            $registrationEmailSender,
            $letterTriggerLauncher,
            $patientSummaryManager,
            $userRepository,
            $patientUpdateMailer,
            $letterManager,
            $pendingVOBRemover
        );
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testEditPatient()
    {
        $formData = ['foo' => 'bar'];
        $user = new User();
        $user->userid = 1;
        $this->docId = 2;
        $requestData = new EditPatientRequestData();
        $requestData->patientLocation = 8;
        $referrer = new PatientReferrer();
        $referrer->referredBy = 10;
        $referrer->source = 11;
        $requestData->referrer = $referrer;
        $requestData->insuranceInfo = [
            'p_m_partyfname' => 'Jane',
            'p_m_partylname' => 'Jones',
        ];
        $patient = new Patient();
        $patient->patientid = 3;
        $patient->referred_by = 10;
        $patient->referred_source = 11;
        $patient->p_m_partyfname = 'Harry';
        $patient->p_m_partylname = 'Jones';
        $responseData = $this->patientUpdater->editPatient($formData, $user, $requestData, $patient);
        $expectedUser = new User();
        $expectedUser->userid = 1;
        $expectedUser->docid = 2;
        $vobData = [
            'user' => $expectedUser,
            'patientId' => 3,
            'userId' => 1,
        ];
        $this->assertEquals($vobData, $this->pendingVOBData);
        $summary = [
            'id' => 3,
            'location' => 8,
        ];
        $this->assertEquals($summary, $this->updatedLocationSummary);
        $this->assertEquals([], $this->letters);
        $this->assertEquals(EditPatientResponseData::PATIENT_EDITED_STATUS, $responseData->status);
        $this->assertNull($responseData->redirectTo);
        $this->assertNull($responseData->sendPinCode);
        $this->assertEquals(self::MAIL_MESSAGE, $responseData->mails->message);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithReferredByChange()
    {
        $formData = ['foo' => 'bar'];
        $user = new User();
        $user->userid = 1;
        $this->docId = 2;
        $requestData = new EditPatientRequestData();
        $requestData->patientLocation = 8;
        $referrer = new PatientReferrer();
        $referrer->referredBy = 100;
        $referrer->source = 11;
        $requestData->referrer = $referrer;
        $requestData->insuranceInfo = [
            'p_m_partyfname' => 'Jane',
            'p_m_partylname' => 'Jones',
        ];
        $patient = new Patient();
        $patient->patientid = 3;
        $patient->referred_by = 10;
        $patient->referred_source = 11;
        $patient->p_m_partyfname = 'Harry';
        $patient->p_m_partylname = 'Jones';
        $this->patientUpdater->editPatient($formData, $user, $requestData, $patient);
        $letters = [
            'docId' => 2,
            'userId' => 1,
        ];
        $this->assertEquals($letters, $this->letters);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithReferredSourceChange()
    {
        $formData = ['foo' => 'bar'];
        $user = new User();
        $user->userid = 1;
        $this->docId = 2;
        $requestData = new EditPatientRequestData();
        $requestData->patientLocation = 8;
        $referrer = new PatientReferrer();
        $referrer->referredBy = 10;
        $referrer->source = 110;
        $requestData->referrer = $referrer;
        $requestData->insuranceInfo = [
            'p_m_partyfname' => 'Jane',
            'p_m_partylname' => 'Jones',
        ];
        $patient = new Patient();
        $patient->patientid = 3;
        $patient->referred_by = 10;
        $patient->referred_source = 11;
        $patient->p_m_partyfname = 'Harry';
        $patient->p_m_partylname = 'Jones';
        $this->patientUpdater->editPatient($formData, $user, $requestData, $patient);
        $letters = [
            'docId' => 2,
            'userId' => 1,
        ];
        $this->assertEquals($letters, $this->letters);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithPinCode()
    {
        $formData = ['foo' => 'bar'];
        $user = new User();
        $user->userid = 1;
        $this->docId = 2;
        $requestData = new EditPatientRequestData();
        $requestData->patientLocation = 8;
        $referrer = new PatientReferrer();
        $referrer->referredBy = 10;
        $referrer->source = 11;
        $requestData->referrer = $referrer;
        $requestData->insuranceInfo = [
            'p_m_partyfname' => 'Jane',
            'p_m_partylname' => 'Jones',
        ];
        $buttons = [
            'send_pin_code' => '1234',
        ];
        $requestData->intendedActions = new EditPatientIntendedActions($buttons);
        $patient = new Patient();
        $patient->patientid = 3;
        $patient->referred_by = 10;
        $patient->referred_source = 11;
        $patient->p_m_partyfname = 'Harry';
        $patient->p_m_partylname = 'Jones';
        $responseData = $this->patientUpdater->editPatient($formData, $user, $requestData, $patient);
        $this->assertNull($responseData->redirectTo);
        $this->assertTrue($responseData->sendPinCode);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithHST()
    {
        $formData = ['foo' => 'bar'];
        $user = new User();
        $user->userid = 1;
        $this->docId = 2;
        $requestData = new EditPatientRequestData();
        $requestData->patientLocation = 8;
        $referrer = new PatientReferrer();
        $referrer->referredBy = 10;
        $referrer->source = 11;
        $requestData->referrer = $referrer;
        $requestData->insuranceInfo = [
            'p_m_partyfname' => 'Jane',
            'p_m_partylname' => 'Jones',
        ];
        $buttons = [
            'send_pin_code' => '1234',
            'send_hst' => 'foo',
        ];
        $requestData->intendedActions = new EditPatientIntendedActions($buttons);
        $patient = new Patient();
        $patient->patientid = 3;
        $patient->referred_by = 10;
        $patient->referred_source = 11;
        $patient->p_m_partyfname = 'Harry';
        $patient->p_m_partylname = 'Jones';
        $responseData = $this->patientUpdater->editPatient($formData, $user, $requestData, $patient);
        $this->assertEquals(PatientUpdater::REDIRECT_URL . 3, $responseData->redirectTo);
        $this->assertNull($responseData->sendPinCode);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function testWithoutInsuranceInfoChange()
    {
        $formData = ['foo' => 'bar'];
        $user = new User();
        $user->userid = 1;
        $this->docId = 2;
        $requestData = new EditPatientRequestData();
        $requestData->patientLocation = 8;
        $referrer = new PatientReferrer();
        $referrer->referredBy = 10;
        $referrer->source = 11;
        $requestData->referrer = $referrer;
        $requestData->insuranceInfo = [
            'p_m_partyfname' => 'Harry',
            'p_m_partylname' => 'Jones',
        ];
        $patient = new Patient();
        $patient->patientid = 3;
        $patient->referred_by = 10;
        $patient->referred_source = 11;
        $patient->p_m_partyfname = 'Harry';
        $patient->p_m_partylname = 'Jones';
        $this->patientUpdater->editPatient($formData, $user, $requestData, $patient);
        $this->assertEquals([], $this->pendingVOBData);
    }

    private function mockPatientUpdateMailer()
    {
        /** @var PatientUpdateMailer|MockInterface $patientUpdateMailer */
        $patientUpdateMailer = \Mockery::mock(PatientUpdateMailer::class);
        $patientUpdateMailer->shouldReceive('handleEmails')
            ->andReturnUsing([$this, 'handleEmailsCallback']);
        return $patientUpdateMailer;
    }

    private function mockLetterManager()
    {
        /** @var LetterManager|MockInterface $letterManager */
        $letterManager = \Mockery::mock(LetterManager::class);
        $letterManager->shouldReceive('manageLetters')
            ->andReturnUsing([$this, 'manageLettersCallback']);
        return $letterManager;
    }

    private function mockPendingVOBRemover()
    {
        /** @var PendingVOBRemover|MockInterface $pendingVOBRemover */
        $pendingVOBRemover = \Mockery::mock(PendingVOBRemover::class);
        $pendingVOBRemover->shouldReceive('removePendingVerificationOfBenefits')
            ->andReturnUsing([$this, 'removePendingVerificationOfBenefitsCallback']);
        return $pendingVOBRemover;
    }

    protected function mockPatientSummaryManager()
    {
        $patientSummaryManager = parent::mockPatientSummaryManager();
        $patientSummaryManager->shouldReceive('updateSummaryWithLocation')
            ->andReturnUsing([$this, 'updateSummaryWithLocationCallback']);
        return $patientSummaryManager;
    }

    public function updateSummaryWithLocationCallback($id, $location)
    {
        $this->updatedLocationSummary = [
            'id' => $id,
            'location' => $location,
        ];
    }

    public function removePendingVerificationOfBenefitsCallback(User $user, $patientId, $userId)
    {
        $this->pendingVOBData = [
            'user' => $user,
            'patientId' => $patientId,
            'userId' => $userId,
        ];
    }

    public function manageLettersCallback($docId, $userId)
    {
        $this->letters = [
            'docId' => $docId,
            'userId' => $userId,
        ];
    }

    public function handleEmailsCallback()
    {
        $mail = new EditPatientMail();
        $mail->message = self::MAIL_MESSAGE;
        return $mail;
    }
}
