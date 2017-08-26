<?php
namespace Tests\Api;

use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Helpers\PasswordGenerator;
use DentalSleepSolutions\Http\Controllers\Auth\AuthController;
use DentalSleepSolutions\Http\Middleware\JwtAdminAuthMiddleware;
use DentalSleepSolutions\Http\Middleware\JwtUserAuthMiddleware;
use DentalSleepSolutions\Structs\Password;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCases\BaseApiTestCase;

class AuthApiTest extends BaseApiTestCase
{
    const ENDPOINT = 'auth';
    const HEALTH_ENDPOINT = 'auth-health';
    const PASSWORD = 'secret';
    const ADMIN_PREFIX = 'a_';

    use DatabaseTransactions;

    /** @var PasswordGenerator */
    private $passwordGenerator;

    /** @var JwtHelper */
    private $jwtHelper;

    public function setUp()
    {
        parent::setUp();
        $this->passwordGenerator = $this->app->make(PasswordGenerator::class);
        $this->jwtHelper = $this->app->make(JwtHelper::class);
        $this->app
            ->config
            ->set('app.debug', true)
        ;
    }

    public function testAuthInvalidCredentials()
    {
        $this->post(self::ENDPOINT);
        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testAuthUserCredentials()
    {
        $user = $this->newUser();
        $this->post(self::ENDPOINT, [
            'username' => $user->username,
            'password' => self::PASSWORD,
        ]);

        $this->assertResponseOk();
        $this->seeJson([
            'status' => 'Authenticated'
        ]);
    }

    public function testAuthAdminCredentials()
    {
        $admin = $this->newAdmin();
        $this->post(self::ENDPOINT, [
            'username' => $admin->username,
            'password' => self::PASSWORD,
            'admin' => 1,
        ]);

        $this->assertResponseOk();
        $this->seeJson([
            'status' => 'Authenticated',
        ]);
    }

    public function testAuthHealthNoAccess()
    {
        $this->get(self::HEALTH_ENDPOINT);
        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testAuthHealthNoDebug()
    {
        $admin = $this->newAdmin();
        $authHeader = $this->generateAuthHeader($admin);

        $this->disableDebugConfig();
        $this->get(self::HEALTH_ENDPOINT, $authHeader);
        $this->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAuthHealth()
    {
        $admin = $this->newAdmin();
        $authHeader = $this->generateAuthHeader($admin);

        $user = $this->newUser();
        $sudoQuery = $this->generateSudoQuery($user);

        $this->get(self::HEALTH_ENDPOINT . '?' . $sudoQuery, $authHeader);
        $this->assertResponseOk();
        $this->seeJson([
            'status' => 'Health',
        ]);
        $this->seeJson([
            'username' => $user->username,
            AuthController::ADMIN_FLAG_INDEX => 0,
        ]);
        $this->seeJson([
            'username' => $admin->username,
            AuthController::ADMIN_FLAG_INDEX => 1,
        ]);
    }

    private function disableDebugConfig()
    {
        $this->app
            ->config
            ->set('app.debug', false)
        ;
    }

    private function generateSudoQuery(User $user)
    {
        $query = http_build_query([
            JwtUserAuthMiddleware::SUDO_FIELD => $user->{JwtUserAuthMiddleware::SUDO_REFERENCE}
        ]);
        return $query;
    }

    private function generateAuthHeader(Admin $admin)
    {
        $token = $this->generateToken($admin);
        $header = [
            JwtAdminAuthMiddleware::AUTH_HEADER => JwtAdminAuthMiddleware::AUTH_HEADER_START . $token
        ];

        return $header;
    }

    private function generateToken(Admin $admin)
    {
        $token = $this->jwtHelper->createToken([
            JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_ADMIN,
            JwtAuth::CLAIM_ID_INDEX => self::ADMIN_PREFIX . $admin->adminid,
        ]);
        return $token;
    }

    private function newUser()
    {
        return $this->newAuthenticatable(User::class);
    }

    private function newAdmin()
    {
        return $this->newAuthenticatable(Admin::class);
    }

    private function newAuthenticatable($authenticatableClass)
    {
        $passwordStruct = new Password();
        $this->passwordGenerator->generatePassword(self::PASSWORD, $passwordStruct);
        $model = factory($authenticatableClass)->create([
            'password' => $passwordStruct->getPassword(),
            'salt' => $passwordStruct->getSalt(),
        ]);

        return $model;
    }
}
