<?php

namespace Tests\Unit\Helpers\EmailHandlers;

use DentalSleepSolutions\Helpers\EmailHandlers\AbstractRegistrationRelatedEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\RememberEmailHandler;
use Tests\TestCases\EmailHandlerTestCase;

class RememberEmailHandlerTest extends EmailHandlerTestCase
{
    /** @var RememberEmailHandler */
    private $rememberEmailHandler;

    public function setUp()
    {
        parent::setUp();
        $mailerDataRetriever = $this->mockMailerDataRetriever();
        $emailSender = $this->mockEmailSender();
        $this->rememberEmailHandler = new RememberEmailHandler($mailerDataRetriever, $emailSender);
    }

    public function testSendEmail()
    {
        $patientId = 1;
        $newEmail = 'john@doe.com';
        $oldEmail = 'old@doe.com';
        $this->rememberEmailHandler->handleEmail($patientId, $newEmail, $oldEmail);
        $this->assertEquals(1, sizeof($this->sentEmails));
        $expectedData = [
            'foo' => 'bar',
            'email' => $newEmail,
            'old_email' => $oldEmail,
            'new_email' => $newEmail,
            'link' => RememberEmailHandler::LOGIN_PAGE . '?email=' . $newEmail,
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
}
