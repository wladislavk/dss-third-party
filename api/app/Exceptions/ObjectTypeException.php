<?php

namespace DentalSleepSolutions\Exceptions;

use Throwable;

class ObjectTypeException extends GeneralException
{
    public function __construct($element, $parentType, $variableName = 'Object', $code = 0, Throwable $previous = null)
    {
        $verb = 'be of type or extend';
        if (interface_exists($parentType)) {
            $verb = 'implement';
        }
        $given = '';
        if (is_object($element)) {
            $given = " " . get_class($element) . " given";
        }
        $message = "$variableName must $verb $parentType.$given";
        parent::__construct($message, $code, $previous);
    }
}
