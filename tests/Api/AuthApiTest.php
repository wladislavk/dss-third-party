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
    use DatabaseTransactions;

    const ENDPOINT = 'auth';
    const HEALTH_ENDPOINT = 'auth-health';
    const PASSWORD = 'secret';
    const ADMIN_PREFIX = 'a_';

    /** @var PasswordGenerator */
    private $passwordGenerator;

    /** @var JwtHelper */
    private $jwtHelper;

    public function setUp()
    {
        parent::setUp();
        $this->passwordGenerator = $this->app->make(PasswordGenerator::class);
        $this->jwtHelper = $this->app->make(JwtHelper::class);
        $this->app->config->set('app.debug', true);
    }

    public function testAuthInvalidCredentials()
    {
        $this->post(self::ENDPOINT);
        $this->assertResponseStatus(Response::HTTP_FORBIDDEN);
    }

    public function testAuthUserCredentials()
    {
        $user = $this->newAuthenticatable(User::class);
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
        $admin = $this->newAuthenticatable(Admin::class);
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
        $admin = $this->newAuthenticatable(Admin::class);
        $authHeader = $this->generateAuthHeader($admin);

        $this->disableDebugConfig();
        $this->get(self::HEALTH_ENDPOINT, $authHeader);
        $this->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAuthHealth()
    {
        $admin = $this->newAuthenticatable(Admin::class);
        $authHeader = $this->generateAuthHeader($admin);

        $user = $this->newAuthenticatable(User::class);
        $sudoQuery = $this->generateSudoQuery($user);

        $this->get(self::HEALTH_ENDPOINT . '?' . $sudoQuery, $authHeader);
        $this->assertResponseOk();
        $response = json_decode($this->response->getContent(), true);
        $this->assertEquals('Health', $response['status']);
        $data = $response['data'];
        $this->assertNotNull($data['admin']);
        $this->assertNotNull($data['user']);
        $this->assertEquals($user->username, $data['user']['username']);
        $this->assertEquals(0, $data['user'][AuthController::ADMIN_FLAG_INDEX]);
        $this->assertEquals($admin->username, $data['admin']['username']);
        $this->assertEquals(1, $data['admin'][AuthController::ADMIN_FLAG_INDEX]);
    }

    private function disableDebugConfig()
    {
        $this->app->config->set('app.debug', false);
    }

    /**
     * @param User $user
     * @return string
     */
    private function generateSudoQuery(User $user)
    {
        $query = http_build_query([
            JwtUserAuthMiddleware::SUDO_FIELD => $user->{JwtUserAuthMiddleware::SUDO_REFERENCE}
        ]);
        return $query;
    }

    /**
     * @param Admin $admin
     * @return array
     */
    private function generateAuthHeader(Admin $admin)
    {
        $token = $this->generateToken($admin);
        $header = [
            JwtAdminAuthMiddleware::AUTH_HEADER => JwtAdminAuthMiddleware::AUTH_HEADER_START . $token
        ];

        return $header;
    }

    /**
     * @param Admin $admin
     * @return string
     */
    private function generateToken(Admin $admin)
    {
        $token = $this->jwtHelper->createToken([
            JwtAuth::CLAIM_ROLE_INDEX => JwtAuth::ROLE_ADMIN,
            JwtAuth::CLAIM_ID_INDEX => self::ADMIN_PREFIX . $admin->adminid,
        ]);
        return $token;
    }

    /**
     * @param string $authenticatableClass
     * @return mixed
     */
    private function newAuthenticatable(string $authenticatableClass)
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
