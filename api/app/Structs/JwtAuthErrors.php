<?php

namespace DentalSleepSolutions\Structs;

abstract class JwtAuthErrors
{
    const NO_ERROR = '';
    const TOKEN_MISSING = 'JWT token is missing';
    const TOKEN_INVALID = 'JWT token is not valid';
    const TOKEN_INACTIVE = 'JWT token is not yet enabled';
    const TOKEN_EXPIRED = 'JWT token is expired';
    const USER_NOT_FOUND = 'User was not found';
    const INVALID_ROLE = 'Role claim not found';
}
