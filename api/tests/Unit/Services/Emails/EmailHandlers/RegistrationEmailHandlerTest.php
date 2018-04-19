<?php

namespace Tests\Unit\Services\Emails\EmailHandlers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\Emails\EmailHandlers\AbstractRegistrationRelatedEmailHandler;
use DentalSleepSolutions\Services\Emails\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Services\Auth\PasswordResetDataSetter;
use DentalSleepSolutions\Structs\RequestedEmails;
use Mockery\MockInterface;
use Tests\TestCases\EmailHandlerTestCase;

class RegistrationEmailHandlerTest extends EmailHandlerTestCase
{
    /** @var array */
    private $updatedModel = [];

    /** @var RegistrationEmailHandler */
    private $registrationEmailHandler;

    public function setUp()
    {
        parent::setUp();
        $mailerDataRetriever = $this->mockMailerDataRetriever();
        $emailSender = $this->mockEmailSender();
        $passwordResetDataSetter = $this->mockPasswordResetDataSetter();
        $patientRepository = $this->mockPatientRepository();
        $this->registrationEmailHandler = new RegistrationEmailHandler(
            $mailerDataRetriever, $emailSender, $passwordResetDataSetter, $patientRepository
        );
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     */
    public function testSendEmail()
    {
        $this->contactData->patientData->recover_hash = '123';
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $hasPatientPortal = true;
        $this->registrationEmailHandler->handleEmail($patientId, $newEmail, $oldEmail, $hasPatientPortal);
        $expectedPatientData = [
            1 => [
                'patientId' => 1,
                'email' => 'john@doe.com',
                'accessType' => 1,
                'recover_hash' => '123',
                'isEmailChanged' => true,
            ],
        ];
        $this->assertEquals($expectedPatientData, $this->updatedModel);
        $this->assertEquals(1, sizeof($this->sentEmails));
        $link = RegistrationEmailHandler::ACTIVATE_PAGE . "?id=1&amp;hash=123";
        $expectedData = [
            'email' => $newEmail,
            'old_email' => $oldEmail,
            'new_email' => $newEmail,
            'link' => $link,
            'legend' => RegistrationEmailHandler::HEAR_FROM_YOU_LEGEND,
        ];
        $firstEmail = $this->sentEmails[0];
        $expectedFirst = [
            'data' => $expectedData,
            'email' => $newEmail,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'subject' => AbstractRegistrationRelatedEmailHandler::EMAIL_SUBJECT,
            'view' => AbstractRegistrationRelatedEmailHandler::EMAIL_VIEW,
        ];
        $this->assertEquals($expectedFirst, $firstEmail);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     */
    public function testWithoutEmailChange()
    {
        $this->contactData->patientData->recover_hash = '123';
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'john@doe.com';
        $hasPatientPortal = true;
        $this->registrationEmailHandler->handleEmail($patientId, $newEmail, $oldEmail, $hasPatientPortal);
        $expectedPatientData = [
            1 => [
                'patientId' => 1,
                'email' => 'john@doe.com',
                'accessType' => 1,
                'recover_hash' => '123',
                'isEmailChanged' => false,
            ],
        ];
        $this->assertEquals($expectedPatientData, $this->updatedModel);
        $this->assertEquals(1, sizeof($this->sentEmails));
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     */
    public function testWithAccessType()
    {
        $this->registrationEmailHandler->setAccessType(2);
        $this->contactData->patientData->recover_hash = '123';
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $hasPatientPortal = true;
        $this->registrationEmailHandler->handleEmail($patientId, $newEmail, $oldEmail, $hasPatientPortal);
        $expectedPatientData = [
            1 => [
                'patientId' => 1,
                'email' => 'john@doe.com',
                'accessType' => 2,
                'recover_hash' => '123',
                'isEmailChanged' => true,
            ],
        ];
        $this->assertEquals($expectedPatientData, $this->updatedModel);
    }

    /**
     * @throws \DentalSleepSolutions\Exceptions\EmailHandlerException
     */
    public function testWithoutPatientPortal()
    {
        $this->contactData->patientData->recover_hash = '123';
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->registrationEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
        $this->assertEquals([], $this->updatedModel);
    }

    public function testCheckIsCorrectType()
    {
        $emails = new RequestedEmails([]);
        $registrationStatus = RegistrationEmailHandler::REGISTRATION_EMAILED_STATUS;
        $newEmail = 'new@email.com';
        $oldEmail = 'old@email.com';
        $isCorrect = $this->registrationEmailHandler->isCorrectType(
            $emails, $registrationStatus, $newEmail, $oldEmail
        );
        $this->assertTrue($isCorrect);
    }

    public function testCheckWithRegistration()
    {
        $emails = new RequestedEmails(['registration' => 1]);
        $registrationStatus = RegistrationEmailHandler::REGISTRATION_EMAILED_STATUS;
        $newEmail = 'new@email.com';
        $oldEmail = 'old@email.com';
        $isCorrect = $this->registrationEmailHandler->isCorrectType(
            $emails, $registrationStatus, $newEmail, $oldEmail
        );
        $this->assertFalse($isCorrect);
    }

    public function testCheckWithBadRegistrationStatus()
    {
        $emails = new RequestedEmails([]);
        $registrationStatus = RegistrationEmailHandler::REGISTERED_STATUS;
        $newEmail = 'new@email.com';
        $oldEmail = 'old@email.com';
        $isCorrect = $this->registrationEmailHandler->isCorrectType(
            $emails, $registrationStatus, $newEmail, $oldEmail
        );
        $this->assertFalse($isCorrect);
    }

    public function testCheckWithoutEmailChange()
    {
        $emails = new RequestedEmails([]);
        $registrationStatus = RegistrationEmailHandler::REGISTRATION_EMAILED_STATUS;
        $newEmail = 'old@email.com';
        $oldEmail = 'old@email.com';
        $isCorrect = $this->registrationEmailHandler->isCorrectType(
            $emails, $registrationStatus, $newEmail, $oldEmail
        );
        $this->assertFalse($isCorrect);
    }

    private function mockPasswordResetDataSetter()
    {
        /** @var PasswordResetDataSetter|MockInterface $passwordResetDataSetter */
        $passwordResetDataSetter = \Mockery::mock(PasswordResetDataSetter::class);
        $passwordResetDataSetter->shouldReceive('setPasswordResetData')
            ->andReturnUsing([$this, 'setPasswordResetDataCallback']);
        return $passwordResetDataSetter;
    }

    public function setPasswordResetDataCallback($patientId, $email, $accessType, $hash, $isEmailChanged)
    {
        return [
            'patientId' => $patientId,
            'email' => $email,
            'accessType' => $accessType,
            RegistrationEmailHandler::RECOVER_HASH => $hash,
            'isEmailChanged' => $isEmailChanged,
        ];
    }

    private function mockPatientRepository()
    {
        /** @var PatientRepository|MockInterface $patientRepository */
        $patientRepository = \Mockery::mock(PatientRepository::class);
        $patientRepository->shouldReceive('updatePatient')
            ->andReturnUsing([$this, 'updatePatientCallback']);
        return $patientRepository;
    }

    public function updatePatientCallback($patientId, array $newPatientData)
    {
        $this->updatedModel[$patientId] = $newPatientData;
    }
}
