<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Services\Emails\EmailHandlers\AbstractEmailHandler;
use DentalSleepSolutions\Services\Emails\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Services\Emails\EmailHandlers\RememberEmailHandler;
use DentalSleepSolutions\Services\Emails\EmailHandlers\UpdateEmailHandler;
use DentalSleepSolutions\Structs\RequestedEmails;
use Illuminate\Support\Facades\App;

class EmailHandlerFactory
{
    const UPDATED_MAIL = 'updated_mail';
    const REGISTRATION_MAIL = 'registration_mail';
    const REMINDER_MAIL = 'reminder_mail';

    // sequence of elements matters
    const EMAIL_TYPES = [
        self::UPDATED_MAIL => UpdateEmailHandler::class,
        self::REMINDER_MAIL => RememberEmailHandler::class,
        self::REGISTRATION_MAIL => RegistrationEmailHandler::class,
    ];

    /**
     * @param string $type
     * @return AbstractEmailHandler
     * @throws GeneralException
     */
    public function getEmailHandler($type)
    {
        if (!array_key_exists($type, self::EMAIL_TYPES)) {
            throw new GeneralException("Type $type is not valid");
        }
        $class = self::EMAIL_TYPES[$type];
        $object = App::make($class);
        $this->checkHandler($object);
        return $object;
    }

    /**
     * @param RequestedEmails $emailTypesForSending
     * @param int $registrationStatus
     * @param string $newEmail
     * @param string $oldEmail
     * @return AbstractEmailHandler|null
     * @throws GeneralException
     */
    public function getCorrectHandler(
        RequestedEmails $emailTypesForSending,
        $registrationStatus,
        $newEmail,
        $oldEmail
    ) {
        foreach (self::EMAIL_TYPES as $class) {
            /** @var AbstractEmailHandler $handler */
            $handler = App::make($class);
            $this->checkHandler($handler);
            if ($handler->isCorrectType($emailTypesForSending, $registrationStatus, $newEmail, $oldEmail)) {
                return $handler;
            }
        }
        return null;
    }

    /**
     * @param object $object
     * @throws GeneralException
     */
    private function checkHandler($object)
    {
        if (!$object instanceof AbstractEmailHandler) {
            throw new GeneralException("Class " . get_class($object) . " must extend " . AbstractEmailHandler::class);
        }
    }
}
