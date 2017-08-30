<?php

namespace DentalSleepSolutions\Structs;

abstract class DentrixAuthErrors
{
    const NO_ERROR = '';
    const COMPANY_TOKEN_MISSING = 'Company key is missing';
    const USER_TOKEN_MISSING = 'User key is missing';
    const COMPANY_TOKEN_INVALID = 'Company key is not valid';
    const USER_TOKEN_INVALID = 'User key is not valid';
    const USER_NOT_FOUND = 'User was not found';
}
