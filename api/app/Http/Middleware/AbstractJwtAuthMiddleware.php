<?php
namespace DentalSleepSolutions\Http\Middleware;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Exceptions\HttpMalformedHeaderException;
use DentalSleepSolutions\Http\Requests\Request;

abstract class AbstractJwtAuthMiddleware
{
    const AUTH_HEADER = 'Authorization';
    const AUTH_HEADER_START = 'Bearer ';

    /** @var JwtAuth */
    protected $auth;

    /**
     * @param JwtAuth $auth
     */
    public function __construct(JwtAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @return string
     * @throws HttpMalformedHeaderException
     */
    protected function getAuthToken(Request $request)
    {
        $authHeader = $request->header(self::AUTH_HEADER, '');
        $authHeaderStart = strlen(self::AUTH_HEADER_START);

        if (substr($authHeader, 0, $authHeaderStart) !== self::AUTH_HEADER_START) {
            throw new HttpMalformedHeaderException();
        }

        $token = substr($authHeader, $authHeaderStart);
        return $token;
    }
}
