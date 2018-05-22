<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Http\Middleware\SudoAuthenticationMiddleware;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCases\MiddlewareTestCase;

class SudoAuthenticationMiddlewareTest extends MiddlewareTestCase
{
    protected $testMiddleware = [
        SudoAuthenticationMiddleware::class,
    ];

    public function testSudoNoId()
    {
        $admin = factory(Admin::class)->create();
        $this->be($admin, JwtHelper::ROLE_ADMIN);
        $this->get(self::TEST_ROUTE);
        $this->assertResponseOk();
        $this->seeJson([
            'username' => $admin->username,
            'user' => null,
            'patient' => null,
        ]);
    }

    public function testSudoNoUser()
    {
        $admin = factory(Admin::class)->create();
        $this->be($admin, JwtHelper::ROLE_ADMIN);
        $user = factory(User::class)->create();
        $sudoQuery = $this->generateSudoUserQuery($user);
        $user->delete();
        $this->get(self::TEST_ROUTE . '?' . $sudoQuery);
        $this->assertResponseOk();
        $this->seeJson([
            'username' => $admin->username,
            'user' => null,
            'patient' => null,
        ]);
    }

    public function testSudoNoPatient()
    {
        $admin = factory(Admin::class)->create();
        $this->be($admin, JwtHelper::ROLE_ADMIN);
        $patient = factory(Patient::class)->create();
        $sudoQuery = $this->generateSudoPatientQuery($patient);
        $patient->delete();
        $this->get(self::TEST_ROUTE . '?' . $sudoQuery);
        $this->assertResponseOk();
        $this->seeJson([
            'username' => $admin->username,
            'user' => null,
            'patient' => null,
        ]);
    }

    public function testSudoAsUser()
    {
        $admin = factory(Admin::class)->create();
        $this->be($admin, JwtHelper::ROLE_ADMIN);
        $user = factory(User::class)->create();
        $sudoQuery = $this->generateSudoUserQuery($user);
        $this->get(self::TEST_ROUTE . '?' . $sudoQuery);
        $this->assertResponseOk();
        $this->seeJson([
            'username' => $admin->username,
            'patient' => null,
        ]);
        $this->seeJson([
            'username' => $user->username,
        ]);
    }

    public function testSudoAsPatient()
    {
        $admin = factory(Admin::class)->create();
        $this->be($admin, JwtHelper::ROLE_ADMIN);
        $patient = factory(Patient::class)->create();
        $sudoQuery = $this->generateSudoPatientQuery($patient);
        $this->get(self::TEST_ROUTE . '?' . $sudoQuery);
        $this->assertResponseOk();
        $this->seeJson([
            'username' => $admin->username,
            'user' => null,
            'email' => $patient->email,
        ]);
    }

    public function testSudoAsBoth()
    {
        $admin = factory(Admin::class)->create();
        $this->be($admin, JwtHelper::ROLE_ADMIN);
        $user = factory(User::class)->create();
        $patient = factory(Patient::class)->create();
        $userSudo = $this->generateSudoUserQuery($user);
        $patientSudo = $this->generateSudoPatientQuery($patient);
        $this->get(self::TEST_ROUTE . '?' . $userSudo . '&' . $patientSudo);
        $this->assertResponseOk();
        $this->seeJson([
            'username' => $admin->username,
            'email' => $patient->email,
        ]);
        $this->seeJson([
            'username' => $user->username,
        ]);
    }

    /**
     * @param Authenticatable $authenticatable
     * @return string
     */
    private function generateSudoUserQuery(Authenticatable $authenticatable)
    {
        $query = http_build_query([
            SudoAuthenticationMiddleware::USER_SUDO_ID => $authenticatable->getAuthIdentifier()
        ]);
        return $query;
    }

    /**
     * @param Authenticatable $authenticatable
     * @return string
     */
    private function generateSudoPatientQuery(Authenticatable $authenticatable)
    {
        $query = http_build_query([
            SudoAuthenticationMiddleware::PATIENT_SUDO_ID => $authenticatable->getAuthIdentifier()
        ]);
        return $query;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function requestHandler(Request $request)
    {
        /** @var \Illuminate\Contracts\Auth\Factory $auth */
        $auth = $this->app['auth'];
        return ApiResponse::responseOk('', [
            'admin' => $auth->guard(JwtHelper::ROLE_ADMIN)->user(),
            'user' => $auth->guard(JwtHelper::ROLE_USER)->user(),
            'patient' => $auth->guard(JwtHelper::ROLE_PATIENT)->user(),
        ]);
    }
}
