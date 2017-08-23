<?php
namespace Tests\Api;

use Carbon\Carbon;
use DentalSleepSolutions\Auth\JwtAuth;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Helpers\JwtHelper;
use DentalSleepSolutions\Helpers\PasswordGenerator;
use DentalSleepSolutions\Structs\Password;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCases\ApiTestCase;

class LegacyAuthApiTest extends ApiTestCase
{
    const ADMIN_FLAG_INDEX = 'admin';
    const PASSWORD = 'secret';
    const TTL = 60;

    use DatabaseTransactions;

    /** @var JwtHelper */
    private $jwtHelper;

    /** @var PasswordGenerator */
    private $passwordGenerator;

    /** @var User */
    private $user;

    /** @var User */
    private $admin;

    public function setUp()
    {
        parent::setUp();

        $this->jwtHelper = $this->app->make(JwtHelper::class);
        $this->passwordGenerator = $this->app->make(PasswordGenerator::class);

        $this->user = $this->newAuthenticatable(User::class);
        $this->admin = $this->newAuthenticatable(Admin::class);

        $this->app->config->set('app.debug', false);
    }

    public function testInvalidCredentials()
    {
        $data = [
            'username' => '',
            'password' => ''
        ];

        $this->json('post', '/auth', $data);
        $this->seeJson(['message' => 'Invalid credentials'])
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ;
    }

    public function testByUserCredentials()
    {
        $data = [
            'username' => $this->user->username,
            'password' => self::PASSWORD,
        ];

        $this->json('post', '/auth', $data);
        $this->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }

    public function testByAdminCredentials()
    {
        $data = [
            'username' => $this->admin->username,
            'password' => self::PASSWORD,
            self::ADMIN_FLAG_INDEX => 1
        ];

        $this->json('post', '/auth', $data);
        $this->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }

    public function testAuthHealthNoAccess()
    {
        $this->json('get', '/auth-health');
        $this->seeJson(['message' => 'Not Found'])
            ->assertResponseStatus(Response::HTTP_NOT_FOUND)
        ;
    }

    public function testAuthHealthNoToken()
    {
        $this->enableDebug();
        $this->json('get', '/auth-health');
        $this->seeJson([
                'status' => 'Health',
                'data' => ['user' => null, 'admin' => null],
            ])
            ->assertResponseOk()
        ;
    }
/*
    public function testAuthHealthUserToken()
    {
        $this->enableDebug();
        $this->json('get', '/auth-health', [], $this->userAuthHeader);
        $this->seeJson([
                'status' => 'Health',
                'admin' => null,
                'username' => $this->user->username,
            ])
            ->assertResponseOk()
        ;
    }

    public function testAuthHealthAdminToken()
    {
        $this->enableDebug();
        $this->json('get', '/auth-health', [], $this->adminAuthHeader);
        $this->seeJson([
                'status' => 'Health',
                'user' => null,
                'username' => $this->admin->username,
            ])
            ->assertResponseOk()
        ;
    }

    public function testAuthAsUserToken()
    {
        $this->json('post', '/auth-as', [], $this->userAuthHeader);
        $this->seeJson(['message' => 'Unauthorized'])
            ->assertResponseStatus(Response::HTTP_UNAUTHORIZED)
        ;
    }

    public function testAuthAsInvalidUser()
    {
        $this->json('post', '/auth-as', ['username' => self::INVALID_USERNAME], $this->adminAuthHeader);
        $this->seeJson(['message' => 'Invalid credentials'])
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ;
    }

    public function testAuthAsValidUser()
    {
        $this->json('post', '/auth-as', ['username' => $this->user->username], $this->adminAuthHeader);
        $this->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }

    public function testAuthAsAuthHealth()
    {
        $this->json('post', '/auth-as', ['username' => $this->user->username], $this->adminAuthHeader);
        $this->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;

        $json = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('token', $json);

        $this->hardRefreshApplication();
        $this->enableDebug();

        $this->json('get', '/auth-health', [], $this->generateAuthHeader('', $json['token']));
        $this->seeJson(['status' => 'Health'])
            ->seeJson(['username' => $this->admin->username])
            ->seeJson(['username' => $this->user->username])
            ->assertResponseOk()
        ;
    }

    public function testRefreshTokenNoToken()
    {
        $this->json('post', '/refresh-token');
        $this->seeJson(['message' => 'Token not provided'])
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ;
    }

    public function testRefreshTokenExpiredToken()
    {
        $this->markTestSkipped('Token validation must be implemented in the controller');
        //return;

        $token = $this->generateJwtToken('u_' . $this->user->userid, true);
        sleep(1);
        $this->json('post', '/refresh-token', [], $this->generateAuthHeader('', $token));
        $this->seeJson(['message' => 'Expired token'])
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ;
    }

    public function testRefreshTokenInvalidToken()
    {
        $this->markTestSkipped('Token validation must be implemented in the controller');
        //return;

        $this->json('post', '/refresh-token', [], $this->generateAuthHeader('', self::INVALID_USERNAME));
        $this->seeJson(['message' => 'Invalid token'])
            ->assertResponseStatus(422)
        ;
    }

    public function testRefreshToken()
    {
        $this->json('post', '/refresh-token', [], $this->userAuthHeader);
        $this->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }
*/
    private function newAuthenticatable($class)
    {
        $passwordStruct = new Password();
        $this->passwordGenerator->generatePassword(self::PASSWORD, $passwordStruct);

        $user = factory($class)->create();
        $user->password = $passwordStruct->getPassword();
        $user->salt = $passwordStruct->getSalt();
        $user->save();

        return $user;
    }

    private function enableDebug()
    {
        $this->app->config->set('app.debug', true);
    }

    private function generateToken($role, $id, $notEnabled = false)
    {
        $expiresAt = Carbon::now()->addSeconds(self::TTL);
        $notBefore = Carbon::now()->addSeconds(-1);

        if ($notEnabled) {
            $expiresAt->addSeconds(self::TTL);
            $notBefore->addSeconds(self::TTL);
        }

        $token = $this->jwtHelper
            ->createToken([
                JwtAuth::CLAIM_ROLE_INDEX => $role,
                JwtAuth::CLAIM_ID_INDEX => $id,
            ], $expiresAt, $notBefore)
        ;

        return $token;
    }
}
