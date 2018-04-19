<?php

namespace Tests\TestCases;

use Carbon\Carbon;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use DentalSleepSolutions\Http\Middleware\AbstractJwtAuthMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware;

abstract class JwtAuthMiddlewateTestCase extends MiddlewareTestCase
{
    const MINIMAL_TTl = 1;
    const TTL = 60;
    const ADMIN_PREFIX = 'a_';
    const USER_PREFIX = 'u_';

    const BASE_64_REGEXP = '[a-zA-Z\d\+\/\_\-]+';
    const TOKEN_REGEXP = self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP;

    /** @var JwtHelper */
    protected $jwtHelper;

    public function setUp()
    {
        parent::setUp();
        $this->jwtHelper = $this->app
            ->make(JwtHelper::class)
        ;
    }

    protected function generateSudoQuery($sudoId)
    {
        $query = http_build_query([
            JwtUserAuthMiddleware::SUDO_FIELD => $sudoId
        ]);
        return $query;
    }

    protected function generateAuthHeader($role, $index, $state = '')
    {
        $token = $this->generateToken($role, $index, $state);
        $header = [
            AbstractJwtAuthMiddleware::AUTH_HEADER => AbstractJwtAuthMiddleware::AUTH_HEADER_START . $token,
        ];
        return $header;
    }

    protected function generateToken($role, $index, $state = '')
    {
        $prefix = self::USER_PREFIX;

        if ($role === JwtAuth::ROLE_ADMIN) {
            $prefix = self::ADMIN_PREFIX;
        }

        $claims = [
            JwtAuth::CLAIM_ROLE_INDEX => $role,
            JwtAuth::CLAIM_ID_INDEX => $prefix . $index,
        ];
        $expiresAt = Carbon::now()->addSeconds(self::TTL);
        $notBefore = null;

        if ($state === 'expired') {
            $expiresAt = Carbon::now()
                ->addSeconds(self::MINIMAL_TTl)
            ;
        }

        if ($state === 'inactive') {
            $expiresAt = Carbon::now()
                ->addSeconds(self::TTL)
            ;
            $notBefore = Carbon::now()
                ->addSeconds(self::TTL)
            ;
        }

        if ($state === 'invalidToken') {
            $claims['iss'] = 'Test';
        }

        if ($state === 'invalidPayload') {
            unset($claims[JwtAuth::CLAIM_ID_INDEX]);
        }

        $token = $this->jwtHelper
            ->createToken($claims, $expiresAt, $notBefore)
        ;

        if ($state === 'expired') {
            sleep(self::MINIMAL_TTl + 1);
        }

        return $token;
    }
}
