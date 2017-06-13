<?php

namespace Tests\Unit\Helpers\EmailHandlers;

use DentalSleepSolutions\Exceptions\EmailHandlerException;
use DentalSleepSolutions\Helpers\EmailHandlers\UpdateEmailHandler;
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
            'foo' => 'bar',
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
            'foo' => 'bar',
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

    public function testWithoutMailingData()
    {
        unset($this->contactData['mailingData']);
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->expectException(EmailHandlerException::class);
        $this->expectExceptionMessage('Mailer data is malformed');
        $this->updateEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
    }

    public function testWithoutPatientData()
    {
        unset($this->contactData['patientData']);
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->expectException(EmailHandlerException::class);
        $this->expectExceptionMessage('Mailer data is malformed');
        $this->updateEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
    }

    public function testWithoutFirstName()
    {
        unset($this->contactData['patientData']['firstname']);
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->expectException(EmailHandlerException::class);
        $this->expectExceptionMessage('Mailer data is malformed');
        $this->updateEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
    }

    public function testWithoutLastName()
    {
        unset($this->contactData['patientData']['lastname']);
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->expectException(EmailHandlerException::class);
        $this->expectExceptionMessage('Mailer data is malformed');
        $this->updateEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
    }
}
