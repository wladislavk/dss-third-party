<?php

namespace Tests\TestCases;

use DentalSleepSolutions\Helpers\EmailSender;
use DentalSleepSolutions\Helpers\MailerDataRetriever;
use Mockery\MockInterface;

class EmailHandlerTestCase extends UnitTestCase
{
    /** @var array */
    protected $sentEmails = [];

    /** @var array */
    protected $contactData = [];

    public function setUp()
    {
        $this->contactData = [
            'patientData' => [
                'firstname' => 'John',
                'lastname' => 'Doe',
            ],
            'mailingData' => [
                'foo' => 'bar',
            ],
        ];
    }

    protected function mockEmailSender()
    {
        /** @var EmailSender|MockInterface $emailSender */
        $emailSender = \Mockery::mock(EmailSender::class);
        $emailSender->shouldReceive('sendEmail')
            ->andReturnUsing([$this, 'sendEmailCallback']);
        return $emailSender;
    }

    public function sendEmailCallback($mailingData, $email, $firstName, $lastName, $subject, $view)
    {
        $this->sentEmails[] = [
            'data' => $mailingData,
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'subject' => $subject,
            'view' => $view,
        ];
    }

    protected function mockMailerDataRetriever()
    {
        /** @var MailerDataRetriever|MockInterface $mailerDataRetriever */
        $mailerDataRetriever = \Mockery::mock(MailerDataRetriever::class);
        $mailerDataRetriever->shouldReceive('retrieveMailerData')
            ->andReturnUsing([$this, 'retrieveMailerDataCallback']);
        return $mailerDataRetriever;
    }

    public function retrieveMailerDataCallback()
    {
        return $this->contactData;
    }
}
