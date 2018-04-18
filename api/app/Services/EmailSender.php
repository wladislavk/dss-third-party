<?php

namespace DentalSleepSolutions\Services;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class EmailSender
{
    /** @var Mailer */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    // TODO: these constants need to be further decoupled to config
    const SENDER_ADDRESS = 'patient@dentalsleepsolutions.com';
    const SENDER_NAME = 'Dental Sleep Solutions';

    /**
     * @param array $mailingData
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $subject
     * @param string $view
     */
    public function sendEmail(
        array $mailingData,
        $email,
        $firstName,
        $lastName,
        $subject,
        $view
    ) {
        $fullName = "$firstName $lastName";
        $headerInfo = [
            'to_email' => $email,
            'to_name' => $fullName,
            'subject' => $subject,
        ];
        $this->mailer->send(
            $view,
            $mailingData,
            function (Message $message) use ($headerInfo) {
                $message
                    ->from(self::SENDER_ADDRESS, self::SENDER_NAME)
                    ->to($headerInfo['to_email'], $headerInfo['to_name'])
                    ->subject($headerInfo['subject'])
                ;
            }
        );
    }
}
