<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\EmailHandlers\AbstractEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\RememberEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\UpdateEmailHandler;
use Illuminate\Support\Facades\App;

class EmailHandlerFactory
{
    const UPDATED_MAIL = 'updated_mail';
    const REGISTRATION_MAIL = 'registration_mail';
    const REMINDER_MAIL = 'reminder_mail';

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
        if (!isset(self::EMAIL_TYPES[$type])) {
            throw new GeneralException("Type $type is not valid");
        }
        $class = self::EMAIL_TYPES[$type];
        if (!$class instanceof AbstractEmailHandler) {
            throw new GeneralException("Class $class must extend " . AbstractEmailHandler::class);
        }
        return App::make($class);
    }
}
