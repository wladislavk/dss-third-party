<?php

namespace DentalSleepSolutions\Exceptions;

class UntestableException extends GeneralException
{
    // exception for code that relies on a constant of a different class and cannot be unit-tested
}
