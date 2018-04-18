<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Admin;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Services\JwtHelper;
use DentalSleepSolutions\Services\PasswordGenerator;
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
