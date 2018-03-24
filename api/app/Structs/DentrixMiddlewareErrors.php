<?php

namespace DentalSleepSolutions\Structs;

abstract class DentrixMiddlewareErrors
{
    const COMPANY_TOKEN_MISSING = 'api_key_company_not_provided';
    const USER_TOKEN_MISSING = 'api_key_user_not_provided';
    const COMPANY_TOKEN_INVALID = 'api_key_company_invalid';
    const USER_TOKEN_INVALID = 'api_key_user_invalid';
    const USER_NOT_FOUND = 'api_user_not_found';
    const KEYS_INVALID = 'api_keys_invalid';
}
