<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Http\Middleware\AuthorizationMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Illuminate\Http\Response;
use Tests\TestCases\MiddlewareTestCase;

class AuthorizationMiddlewareTest extends MiddlewareTestCase
{
    protected $testMiddleware = [
        AuthorizationMiddleware::class . ':' . JwtHelper::ROLE_USER . '|' . JwtHelper::ROLE_PATIENT,
    ];

    protected function setUpTestEndpoint()
    {
        $this->app
            ->router
            ->any(self::TEST_ROUTE, [
                'middleware' => $this->testMiddleware,
                'uses' => function (Request $request) {
                    return $this->requestHandler($request);
                }
            ])
        ;
    }

    public function testUnauthorized()
    {
        $admin = factory(Admin::class)->create();
        $this->be($admin, JwtHelper::ROLE_ADMIN);
        $this->get(self::TEST_ROUTE);
        $this->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAuthorized()
    {
        $patient = factory(Patient::class)->create();
        $this->be($patient, JwtHelper::ROLE_PATIENT);
        $this->get(self::TEST_ROUTE);
        $this->assertResponseOk();
    }
}
