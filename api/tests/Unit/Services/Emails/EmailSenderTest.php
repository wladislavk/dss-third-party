<?php

namespace Tests\Unit\Services\Emails;

use DentalSleepSolutions\Services\Emails\EmailSender;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class EmailSenderTest extends UnitTestCase
{
    /** @var string */
    private $view;

    /** @var array */
    private $mailingData;

    /** @var Message */
    private $message;

    /** @var EmailSender */
    private $emailSender;

    public function setUp()
    {
        $mailer = $this->mockMailer();
        $this->emailSender = new EmailSender($mailer);
    }

    public function testSendEmail()
    {
        $mailingData = ['foo', 'bar'];
        $email = 'test@test.com';
        $firstName = 'John';
        $lastName = 'Doe';
        $subject = 'My subject';
        $view = 'my.view';
        $this->emailSender->sendEmail($mailingData, $email, $firstName, $lastName, $subject, $view);
        $this->assertEquals($view, $this->view);
        $this->assertEquals($mailingData, $this->mailingData);
        $swiftMessage = $this->message->getSwiftMessage();
        $this->assertEquals($subject, $swiftMessage->getSubject());
        $this->assertEquals([$email => 'John Doe'], $swiftMessage->getTo());
        $this->assertEquals([EmailSender::SENDER_ADDRESS => EmailSender::SENDER_NAME], $swiftMessage->getFrom());
    }

    private function mockMailer()
    {
        /** @var Mailer|MockInterface $mailer */
        $mailer = \Mockery::mock(Mailer::class);
        $mailer->shouldReceive('send')->andReturnUsing([$this, 'sendCallback']);
        return $mailer;
    }

    /**
     * @param string $view
     * @param array $data
     * @param callable $callable
     */
    public function sendCallback($view, array $data, $callable)
    {
        $this->view = $view;
        $this->mailingData = $data;
        $message = new Message(new \Swift_Message);
        call_user_func($callable, $message);
        $this->message = $message;
    }
}
