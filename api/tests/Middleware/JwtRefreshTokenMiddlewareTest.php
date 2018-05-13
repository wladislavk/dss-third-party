<?php

namespace Tests\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\AbstractJwtAuthMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtRefreshTokenMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware;
use Tests\TestCases\JwtAuthMiddlewareTestCase;

class JwtRefreshTokenMiddlewareTest extends JwtAuthMiddlewareTestCase
{
    protected $testMiddleware = [
        JwtAdminAuthMiddleware::class,
        JwtUserAuthMiddleware::class,
        JwtRefreshTokenMiddleware::class,
    ];

    public function testRefreshAdmin()
    {
        $admin = factory(Admin::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid);

        $this->get(self::TEST_ROUTE, $authHeader);
        $claims = $this->getResponseClaims();

        $this->assertResponseOk();
        $this->seeHeader(AbstractJwtAuthMiddleware::AUTH_HEADER);
        $this->assertRegExp(
            '/^Bearer ' . self::TOKEN_REGEXP. '$/',
            $this->response->headers->get(AbstractJwtAuthMiddleware::AUTH_HEADER)
        );

        $this->assertEquals(JwtAuth::ROLE_ADMIN, $claims[JwtAuth::CLAIM_ROLE_INDEX]);
        $this->assertEquals(self::ADMIN_PREFIX . $admin->adminid, $claims[JwtAuth::CLAIM_ID_INDEX]);
    }

    public function testRefreshUser()
    {
        $user = factory(User::class)->create();
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_USER, $user->userid);

        $this->get(self::TEST_ROUTE, $authHeader);
        $claims = $this->getResponseClaims();

        $this->assertResponseOk();
        $this->seeHeader(AbstractJwtAuthMiddleware::AUTH_HEADER);
        $this->assertRegExp(
            '/^Bearer ' . self::TOKEN_REGEXP. '$/',
            $this->response->headers->get(AbstractJwtAuthMiddleware::AUTH_HEADER)
        );

        $this->assertEquals(JwtAuth::ROLE_USER, $claims[JwtAuth::CLAIM_ROLE_INDEX]);
        $this->assertEquals(self::USER_PREFIX . $user->userid, $claims[JwtAuth::CLAIM_ID_INDEX]);
    }

    public function testRefreshSudo()
    {
        $user = factory(User::class)->create();
        $admin = factory(Admin::class)->create();
        $sudoQuery = $this->generateSudoUserQuery($user);
        $authHeader = $this->generateAuthHeader(JwtAuth::ROLE_ADMIN, $admin->adminid);

        $this->get(self::TEST_ROUTE . '?' . $sudoQuery, $authHeader);
        $claims = $this->getResponseClaims();

        $this->assertResponseOk();
        $this->seeHeader(AbstractJwtAuthMiddleware::AUTH_HEADER);
        $this->assertRegExp(
            '/^Bearer ' . self::TOKEN_REGEXP. '$/',
            $this->response->headers->get(AbstractJwtAuthMiddleware::AUTH_HEADER)
        );
        $this->assertEquals(JwtAuth::ROLE_ADMIN, $claims[JwtAuth::CLAIM_ROLE_INDEX]);
        $this->assertEquals(self::ADMIN_PREFIX . $admin->adminid, $claims[JwtAuth::CLAIM_ID_INDEX]);
    }

    private function getResponseClaims()
    {
        $token = $this->getResponseToken();
        $claims = $this->jwtHelper
            ->parseToken($token)
        ;
        return $claims;
    }

    private function getResponseToken()
    {
        $header = $this->response->headers->get(AbstractJwtAuthMiddleware::AUTH_HEADER);
        $token = str_replace(AbstractJwtAuthMiddleware::AUTH_HEADER_START, '', $header);
        return $token;
    }
}
