<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\JwtAuthenticationMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtRefreshTokenMiddleware;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Tests\TestCases\JwtAuthenticationMiddlewareTestCase;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtRefreshTokenMiddlewareTest extends JwtAuthenticationMiddlewareTestCase
{
    protected $testMiddleware = [
        JwtRefreshTokenMiddleware::class,
    ];

    public function testRefreshAdmin()
    {
        $admin = factory(Admin::class)->create();
        $this->be($admin, JwtHelper::ROLE_ADMIN);
        $this->get(self::TEST_ROUTE);
        $claims = $this->getResponseClaims();

        $this->assertResponseOk();
        $this->seeHeader(JwtAuthenticationMiddleware::AUTH_HEADER);
        $this->assertRegExp(
            '/^Bearer ' . self::TOKEN_REGEXP. '$/',
            $this->response->headers->get(JwtAuthenticationMiddleware::AUTH_HEADER)
        );
        $this->assertEquals(JwtHelper::ROLE_ADMIN, $claims[JwtHelper::CLAIM_ROLE_INDEX]);
        $this->assertEquals($admin->adminid, $claims[JwtHelper::CLAIM_ID_INDEX]);
    }

    public function testRefreshUser()
    {
        $user = factory(User::class)->create();
        $this->be($user, JwtHelper::ROLE_USER);
        $this->get(self::TEST_ROUTE);
        $claims = $this->getResponseClaims();

        $this->assertResponseOk();
        $this->seeHeader(JwtAuthenticationMiddleware::AUTH_HEADER);
        $this->assertRegExp(
            '/^Bearer ' . self::TOKEN_REGEXP. '$/',
            $this->response->headers->get(JwtAuthenticationMiddleware::AUTH_HEADER)
        );
        $this->assertEquals(JwtHelper::ROLE_USER, $claims[JwtHelper::CLAIM_ROLE_INDEX]);
        $this->assertEquals($user->userid, $claims[JwtHelper::CLAIM_ID_INDEX]);
    }

    public function testRefreshPatient()
    {
        $patient = factory(Patient::class)->create();
        $this->be($patient, JwtHelper::ROLE_PATIENT);
        $this->get(self::TEST_ROUTE);
        $claims = $this->getResponseClaims();

        $this->assertResponseOk();
        $this->seeHeader(JwtAuthenticationMiddleware::AUTH_HEADER);
        $this->assertRegExp(
            '/^Bearer ' . self::TOKEN_REGEXP. '$/',
            $this->response->headers->get(JwtAuthenticationMiddleware::AUTH_HEADER)
        );
        $this->assertEquals(JwtHelper::ROLE_PATIENT, $claims[JwtHelper::CLAIM_ROLE_INDEX]);
        $this->assertEquals($patient->patientid, $claims[JwtHelper::CLAIM_ID_INDEX]);
    }

    /**
     * @return array
     */
    private function getResponseClaims(): array
    {
        $header = $this->response->headers->get(JwtAuthenticationMiddleware::AUTH_HEADER);
        $token = str_replace(JwtAuthenticationMiddleware::AUTH_HEADER_START, '', $header);
        try {
            $claims = $this->jwtHelper->parseToken($token);
        } catch (TokenInvalidException $e) {
            return [];
        }
        return $claims;
    }
}
