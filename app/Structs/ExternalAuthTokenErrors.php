<?php

namespace DentalSleepSolutions\Structs;

abstract class ExternalAuthTokenErrors
{
    const NO_ERROR = '';
    const COMPANY_KEY_MISSING = 'Company key is missing';
    const USER_KEY_MISSING = 'User key is missing';
    const COMPANY_KEY_INVALID = 'Company key is not valid';
    const USER_KEY_INVALID = 'User key is not valid';
    const USER_NOT_FOUND = 'User was not found';
}
