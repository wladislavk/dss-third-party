<?php

namespace DentalSleepSolutions\Exceptions;

use Throwable;

class MissingElementException extends GeneralException
{
    public function __construct(array $keys, $arrayName = 'Array', $code = 0, Throwable $previous = null)
    {
        if (!sizeof($keys)) {
            parent::__construct('', $code, $previous);
            return;
        }
        $keyWord = 'keys';
        if (sizeof($keys) == 1) {
            $keyWord = 'key';
        }
        $keyString = '\'' . join('\', \'', $keys) . '\'';
        $message = "$arrayName must contain $keyWord $keyString";
        parent::__construct($message, $code, $previous);
    }
}
