<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use function sleep;
use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\StaticClasses\SudoHelper;
use Tymon\JWTAuth\JWTAuth;
use Carbon\Carbon;

class LegacyAuthApiTest extends ApiTestCase
{
    const PASSWORD = 'secret';
    const ADMIN_FLAG = 1;
    const NON_ADMIN_FLAG = 0;
    const HASH_ALGORITHM = 'sha256';
    const INVALID_USERNAME = "\nFoo\t + \tBar\n";

    use DatabaseTransactions;

    /** @var User */
    private $user;

    /** @var Admin */
    private $admin;

    /** @var JWTAuth */
    private $jwt;

    /** @var UserRepository */
    private $repository;

    /** @var array */
    private $userAuthHeader;

    /** @var array */
    private $adminAuthHeader;

    /** @var array */
    private $sudoAuthHeader;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->admin = factory(Admin::class)->create();

        $this->setupGenerateJwtToken();
        $this->setupAuthHeaders();

        $this->hardRefreshApplication();
    }

    public function testInvalidCredentials()
    {
        $data = ['username' => '', 'password' => ''];

        $this->json('post', '/auth', $data)
            ->seeJson(['message' => 'Invalid credentials'])
            ->assertResponseStatus(422)
        ;
    }

    public function testByUserCredentials()
    {
        $record = $this->user;
        $record->password = hash(self::HASH_ALGORITHM, self::PASSWORD . $record->salt);
        $record->save();

        $data = ['username' => $record->username, 'password' => self::PASSWORD];

        $this->json('post', '/auth', $data)
            ->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }

    public function testByAdminCredentials()
    {
        $record = $this->admin;
        $record->password = hash(self::HASH_ALGORITHM, self::PASSWORD . $record->salt);
        $record->save();

        $data = ['username' => $record->username, 'password' => self::PASSWORD, 'admin' => self::ADMIN_FLAG];

        $this->json('post', '/auth', $data)
            ->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }

    public function testAuthHealthNoAccess()
    {
        $this->json('get', '/auth-health')
            ->seeJson(['message' => 'Not Found'])
            ->assertResponseStatus(404)
        ;
    }

    public function testAuthHealthNoToken()
    {
        $this->enableDebug();
        $this->json('get', '/auth-health')
            ->seeJson([
                'status' => 'Health',
                'data' => ['user' => null, 'admin' => null],
            ])
            ->assertResponseStatus(200)
        ;
    }

    public function testAuthHealthUserToken()
    {
        $this->enableDebug();
        $this->json('get', '/auth-health', [], $this->userAuthHeader)
            ->seeJson([
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
        $this->json('get', '/auth-health', [], $this->adminAuthHeader)
            ->seeJson([
                'status' => 'Health',
                'user' => null,
                'username' => $this->admin->username,
            ])
            ->assertResponseOk()
        ;
    }

    public function testAuthHealthSudoToken()
    {
        $this->enableDebug();
        $this->json('get', '/auth-health', [], $this->sudoAuthHeader)
            ->seeJson(['status' => 'Health'])
            ->seeJson(['username' => $this->admin->username])
            ->seeJson(['username' => $this->user->username])
            ->assertResponseOk()
        ;
    }

    public function testAuthAsUserToken()
    {
        $this->json('post', '/auth-as', [], $this->userAuthHeader)
            ->seeJson(['message' => 'Unauthorized'])
            ->assertResponseStatus(401)
        ;
    }

    public function testAuthAsInvalidUser()
    {
        $this->json('post', '/auth-as', ['username' => self::INVALID_USERNAME], $this->adminAuthHeader)
            ->seeJson(['message' => 'Invalid credentials'])
            ->assertResponseStatus(422)
        ;
    }

    public function testAuthAsValidUser()
    {
        $this->json('post', '/auth-as', ['username' => $this->user->username], $this->adminAuthHeader)
            ->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }

    public function testAuthAsAuthHealth()
    {
        $this->json('post', '/auth-as', ['username' => $this->user->username], $this->adminAuthHeader)
            ->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;

        $json = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('token', $json);

        $this->hardRefreshApplication();
        $this->enableDebug();

        $this->json('get', '/auth-health', [], $this->generateAuthHeader('', $json['token']))
            ->seeJson(['status' => 'Health'])
            ->seeJson(['username' => $this->admin->username])
            ->seeJson(['username' => $this->user->username])
            ->assertResponseOk()
        ;
    }

    public function testRefreshTokenNoToken()
    {
        $this->json('post', '/refresh-token')
            ->seeJson(['message' => 'Token not provided'])
            ->assertResponseStatus(422)
        ;
    }

    public function testRefreshTokenExpiredToken()
    {
        $this->markTestSkipped('Token validation must be implemented in the controller');
        return;

        $token = $this->generateJwtToken(SudoHelper::USER_PREFIX . $this->user->userid, true);
        sleep(1);
        $this->json('post', '/refresh-token', [], $this->generateAuthHeader('', $token))
            ->seeJson(['message' => 'Expired token'])
            ->assertResponseStatus(422)
        ;
    }

    public function testRefreshTokenInvalidToken()
    {
        $this->markTestSkipped('Token validation must be implemented in the controller');
        return;

        $this->json('post', '/refresh-token', [], $this->generateAuthHeader('', self::INVALID_USERNAME))
            ->seeJson(['message' => 'Invalid token'])
            ->assertResponseStatus(422)
        ;
    }

    public function testRefreshToken()
    {
        $this->json('post', '/refresh-token', [], $this->userAuthHeader)
            ->seeJson(['status' => 'Authenticated'])
            ->assertResponseOk()
        ;
    }

    private function setupGenerateJwtToken()
    {
        $this->jwt = $this->app->make(JWTAuth::class);
        $this->repository = $this->app->make(UserRepository::class);
    }

    private function setupAuthHeaders()
    {
        $this->userAuthHeader = $this->generateAuthHeader(SudoHelper::USER_PREFIX . $this->user->userid);
        $this->adminAuthHeader = $this->generateAuthHeader(SudoHelper::ADMIN_PREFIX . $this->admin->adminid);
        $this->sudoAuthHeader = $this->generateAuthHeader(SudoHelper::sudoId(
            SudoHelper::ADMIN_PREFIX . $this->admin->adminid, SudoHelper::USER_PREFIX . $this->user->userid
        ));
    }

    private function hardRefreshApplication()
    {
        $this->refreshApplication();
        $this->withoutMiddleware();
        $this->setupInitialConfig();
    }

    private function setupInitialConfig()
    {
        $this->app->config->set('app.debug', false);
        $this->app->config->set('app.testing.tokens', true);
    }
    
    private function enableDebug()
    {
        $this->app->config->set('app.debug', true);
    }

    private function generateJwtToken($id, $expired = false)
    {
        $timeToLive = 60;

        if ($expired) {
            $timeToLive = 0;
        }

        $collection = $this->repository->findById($id);

        if (!isset($collection[0])) {
            return '';
        }

        if (!isset($collection[1])) {
            return $this->jwt->fromUser($collection[0]);
        }

        $collection[0]->id = SudoHelper::sudoId($collection[0]->id, $collection[1]->id);
        return $this->jwt->fromUser($collection[0], ['ttl' => $timeToLive]);
    }

    private function generateAuthHeader($id, $token = '')
    {
        if (strlen($id)) {
            $token = $this->generateJwtToken($id);
        }

        $header = ['Authorization' => "Bearer $token"];
        return $header;
    }
}
