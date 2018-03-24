<?php

namespace DentalSleepSolutions\Structs;

abstract class JwtMiddlewareErrors
{
    const TOKEN_MISSING = 'jwt_token_missing';
    const TOKEN_INVALID = 'jwt_token_invalid';
    const TOKEN_INACTIVE = 'jwt_token_inactive';
    const TOKEN_EXPIRED = 'jwt_token_expired';
    const USER_NOT_FOUND = 'user_not_found';
}
