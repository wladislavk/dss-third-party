<?php

namespace DentalSleepSolutions\Services\Emails\EmailHandlers;

abstract class AbstractRegistrationRelatedEmailHandler extends AbstractEmailHandler
{
    const EMAIL_SUBJECT = 'Online Patient Registration';
    const EMAIL_VIEW = 'emails.registration';

    /**
     * @return string
     */
    protected function getEmailSubject()
    {
        return self::EMAIL_SUBJECT;
    }

    /**
     * @return string
     */
    protected function getEmailView()
    {
        return self::EMAIL_VIEW;
    }

    /**
     * @param string $newEmail
     * @param string $oldEmail
     * @return array
     */
    protected function getAddresses($newEmail, $oldEmail)
    {
        return [$newEmail];
    }
}
