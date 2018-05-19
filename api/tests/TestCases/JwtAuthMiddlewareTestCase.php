<?php

namespace Tests\TestCases;

use Carbon\Carbon;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\AbstractJwtAuthMiddleware;
use DentalSleepSolutions\Services\Auth\JwtHelper;

abstract class JwtAuthMiddlewareTestCase extends MiddlewareTestCase
{
    const MINIMAL_TTL = 1;
    const TTL = 60;
    const ADMIN_PREFIX = 'a_';
    const USER_PREFIX = 'u_';
    const PATIENT_PREFIX = 'p_';

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

    /**
     * @param User $user
     * @return string
     */
    protected function generateSudoUserQuery(User $user)
    {
        $query = http_build_query([
            AbstractJwtAuthMiddleware::USER_SUDO_ID => $user->{AbstractJwtAuthMiddleware::USER_MODEL_ID}
        ]);
        return $query;
    }

    /**
     * @param Patient $patient
     * @return string
     */
    protected function generateSudoPatientQuery(Patient $patient)
    {
        $query = http_build_query([
            AbstractJwtAuthMiddleware::PATIENT_SUDO_ID => $patient->{AbstractJwtAuthMiddleware::PATIENT_MODEL_ID}
        ]);
        return $query;
    }

    /**
     * @param string $role
     * @param string $index
     * @param string $state
     * @return array
     */
    protected function generateAuthHeader($role, $index, $state = '')
    {
        $token = $this->generateToken($role, $index, $state);
        $header = [
            AbstractJwtAuthMiddleware::AUTH_HEADER => AbstractJwtAuthMiddleware::AUTH_HEADER_START . $token,
        ];
        return $header;
    }

    /**
     * @param string $role
     * @param string $index
     * @param string $state
     * @return string
     * @throws \DentalSleepSolutions\Exceptions\JwtException
     */
    protected function generateToken($role, $index, $state = '')
    {
        $prefix = self::USER_PREFIX;

        if ($role === JwtAuth::ROLE_ADMIN) {
            $prefix = self::ADMIN_PREFIX;
        }

        if ($role === JwtAuth::ROLE_PATIENT) {
            $prefix = self::PATIENT_PREFIX;
        }

        $claims = [
            JwtAuth::CLAIM_ROLE_INDEX => $role,
            JwtAuth::CLAIM_ID_INDEX => $prefix . $index,
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
            unset($claims[JwtAuth::CLAIM_ID_INDEX]);
        }

        $token = $this->jwtHelper
            ->createToken($claims, $expiresAt, $notBefore)
        ;

        if ($state === 'expired') {
            sleep(self::MINIMAL_TTL + 1);
        }

        return $token;
    }
}
