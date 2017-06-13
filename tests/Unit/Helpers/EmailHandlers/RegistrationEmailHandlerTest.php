<?php

namespace Tests\Unit\Helpers\EmailHandlers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Exceptions\EmailHandlerException;
use DentalSleepSolutions\Helpers\EmailHandlers\AbstractRegistrationRelatedEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Helpers\PasswordResetDataSetter;
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
        $patientModel = $this->mockPatientModel();
        $this->registrationEmailHandler = new RegistrationEmailHandler(
            $mailerDataRetriever, $emailSender, $passwordResetDataSetter, $patientModel
        );
    }

    public function testSendEmail()
    {
        $this->contactData['patientData'][RegistrationEmailHandler::RECOVER_HASH] = '123';
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->registrationEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
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
            'foo' => 'bar',
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

    public function testWithoutEmailChange()
    {
        $this->contactData['patientData'][RegistrationEmailHandler::RECOVER_HASH] = '123';
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'john@doe.com';
        $this->registrationEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
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

    public function testWithAccessType()
    {
        $this->registrationEmailHandler->setAccessType(2);
        $this->contactData['patientData'][RegistrationEmailHandler::RECOVER_HASH] = '123';
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->registrationEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
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

    public function testWithoutRecoverHash()
    {
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->expectException(EmailHandlerException::class);
        $this->expectExceptionMessage('Mailer data is malformed');
        $this->registrationEmailHandler->handleEmail($patientId, $oldEmail, $newEmail);
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

    private function mockPatientModel()
    {
        /** @var Patient|MockInterface $patientModel */
        $patientModel = \Mockery::mock(Patient::class);
        $patientModel->shouldReceive('updatePatient')
            ->andReturnUsing([$this, 'updatePatientCallback']);
        return $patientModel;
    }

    public function updatePatientCallback($patientId, array $newPatientData)
    {
        $this->updatedModel[$patientId] = $newPatientData;
    }
}
