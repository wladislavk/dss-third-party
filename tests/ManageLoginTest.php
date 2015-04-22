<?php
/*
use Ds3\Http\Controllers\AuthController;
use Ds3\Http\Requests\AuthFormRequest;

use Ds3\Repositories\UserRepository;
use Ds3\Repositories\LoginRepository;
use Ds3\Repositories\LoginDetailRepository;

class ManageIndexTest extends TestCase
{
    private $authController;

    public function testLoginPage()
    {
        $response = $this->call('GET', '/manage/login');

        $this->assertResponseOk();
    }

    public function testAuth()
    {
        $this->authController = new AuthController(new UserRepository, new LoginRepository, new LoginDetailRepository);

        $request = new AuthFormRequest();

        $request->replace(array(
            'username'  => 'doc12',
            'password'  => 'admin'
        ));

        $response = $this->authController->login($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertSessionHas('companyId');
        $this->assertSessionHas('docId');
        $this->assertSessionHas('userType');
        $this->assertSessionHas('userId');
    }
}
*/