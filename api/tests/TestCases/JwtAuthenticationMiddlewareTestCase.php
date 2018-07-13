<?php

namespace Tests\TestCases;

use Carbon\Carbon;
use DentalSleepSolutions\Http\Middleware\JwtAuthenticationMiddleware;
use DentalSleepSolutions\Services\Auth\JwtHelper;

abstract class JwtAuthenticationMiddlewareTestCase extends MiddlewareTestCase
{
    const MINIMAL_TTL = 1;
    const TTL = 60;
    const BASE_64_REGEXP = '[a-zA-Z\d\+\/\_\-]+';
    const TOKEN_REGEXP = self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP;

    /** @var JwtHelper */
    protected $jwtHelper;

    public function setUp()
    {
        parent::setUp();
        $this->jwtHelper = $this->app->make(JwtHelper::class);
    }

    /**
     * @param string $role
     * @param string $index
     * @param string $state
     * @return array
     */
    protected function generateAuthHeader(string $role, string $index, string $state = ''): array
    {
        $token = $this->generateToken($role, $index, $state);
        $header = [
            JwtAuthenticationMiddleware::AUTH_HEADER => JwtAuthenticationMiddleware::AUTH_HEADER_START . $token,
        ];
        return $header;
    }

    /**
     * @param string $role
     * @param string $index
     * @param string $state
     * @return string
     */
    protected function generateToken(string $role, string $index, string $state = ''): string
    {
        $claims = [
            JwtHelper::CLAIM_ROLE_INDEX => $role,
            JwtHelper::CLAIM_ID_INDEX => $index,
        ];
        $expiresAt = Carbon::now()->addSeconds(self::TTL);
        $notBefore = null;

        if ($state === 'expired') {
            $expiresAt = Carbon::now()
                ->addSeconds(self::MINIMAL_TTL)
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
            unset($claims[JwtHelper::CLAIM_ID_INDEX]);
        }

        $token = $this->jwtHelper->createToken($claims, $expiresAt, $notBefore);

        if ($state === 'expired') {
            sleep(self::MINIMAL_TTL + 1);
        }

        return $token;
    }
}
