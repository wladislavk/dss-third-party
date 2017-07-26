<?php

namespace Tests\Unit\Helpers\EmailHandlers;

use DentalSleepSolutions\Exceptions\EmailHandlerException;
use DentalSleepSolutions\Helpers\EmailHandlers\AbstractEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\UpdateEmailHandler;
use DentalSleepSolutions\Structs\RequestedEmails;
use Tests\TestCases\EmailHandlerTestCase;

class UpdateEmailHandlerTest extends EmailHandlerTestCase
{
    /** @var UpdateEmailHandler */
    private $updateEmailHandler;

    public function setUp()
    {
        parent::setUp();
        $mailerDataRetriever = $this->mockMailerDataRetriever();
        $emailSender = $this->mockEmailSender();
        $this->updateEmailHandler = new UpdateEmailHandler($mailerDataRetriever, $emailSender);
    }

    public function testSendEmail()
    {
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->updateEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
        $this->assertEquals(2, sizeof($this->sentEmails));
        $expectedData = [
            'email' => $newEmail,
            'old_email' => $oldEmail,
            'new_email' => $newEmail,
            'legend' => UpdateEmailHandler::UPDATED_BY_OTHER_LEGEND,
        ];
        $firstEmail = $this->sentEmails[0];
        $expectedFirst = [
            'data' => $expectedData,
            'email' => $newEmail,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'subject' => UpdateEmailHandler::EMAIL_SUBJECT,
            'view' => UpdateEmailHandler::EMAIL_VIEW,
        ];
        $this->assertEquals($expectedFirst, $firstEmail);
        $secondEmail = $this->sentEmails[1];
        $expectedSecond = [
            'data' => $expectedData,
            'email' => $oldEmail,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'subject' => UpdateEmailHandler::EMAIL_SUBJECT,
            'view' => UpdateEmailHandler::EMAIL_VIEW,
        ];
        $this->assertEquals($expectedSecond, $secondEmail);
    }

    public function testWithoutOldEmail()
    {
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $this->updateEmailHandler->handleEmail($patientId, $newEmail);
        $this->assertEquals(1, sizeof($this->sentEmails));
        $expectedData = [
            'email' => $newEmail,
            'old_email' => '',
            'new_email' => $newEmail,
            'legend' => UpdateEmailHandler::UPDATED_BY_OTHER_LEGEND,
        ];
        $firstEmail = $this->sentEmails[0];
        $expectedFirst = [
            'data' => $expectedData,
            'email' => $newEmail,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'subject' => UpdateEmailHandler::EMAIL_SUBJECT,
            'view' => UpdateEmailHandler::EMAIL_VIEW,
        ];
        $this->assertEquals($expectedFirst, $firstEmail);
    }

    public function testWithoutEmailChange()
    {
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = ' John@Doe.com';
        $this->updateEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
        $this->assertEquals(0, sizeof($this->sentEmails));
    }

    public function testCheckIsCorrectType()
    {
        $emails = new RequestedEmails([]);
        $registrationStatus = AbstractEmailHandler::REGISTERED_STATUS;
        $newEmail = 'new@email.com';
        $oldEmail = 'old@email.com';
        $isCorrect = $this->updateEmailHandler->isCorrectType(
            $emails, $registrationStatus, $newEmail, $oldEmail
        );
        $this->assertTrue($isCorrect);
    }

    public function testCheckWithIncorrectStatus()
    {
        $emails = new RequestedEmails([]);
        $registrationStatus = AbstractEmailHandler::REGISTRATION_EMAILED_STATUS;
        $newEmail = 'new@email.com';
        $oldEmail = 'old@email.com';
        $isCorrect = $this->updateEmailHandler->isCorrectType(
            $emails, $registrationStatus, $newEmail, $oldEmail
        );
        $this->assertFalse($isCorrect);
    }

    public function testCheckWithoutEmailChange()
    {
        $emails = new RequestedEmails([]);
        $registrationStatus = AbstractEmailHandler::REGISTERED_STATUS;
        $newEmail = 'old@email.com';
        $oldEmail = 'old@email.com';
        $isCorrect = $this->updateEmailHandler->isCorrectType(
            $emails, $registrationStatus, $newEmail, $oldEmail
        );
        $this->assertFalse($isCorrect);
    }
}
