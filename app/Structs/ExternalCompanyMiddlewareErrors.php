<?php

namespace DentalSleepSolutions\Structs;

abstract class ExternalCompanyMiddlewareErrors
{
    const COMPANY_KEY_MISSING = 'api_key_company_not_provided';
    const USER_KEY_MISSING = 'api_key_user_not_provided';
    const COMPANY_KEY_INVALID = 'api_key_company_invalid';
    const USER_KEY_INVALID = 'api_key_user_invalid';
    const USER_NOT_FOUND = 'api_user_not_found';
    const KEYS_INVALID = 'api_keys_invalid';
}
