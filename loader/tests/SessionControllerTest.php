<?php
/*
class SessionControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mock = $this->mock('Ds3\Auth\Authenticate');
    }

    public function mock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }


    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetUserName()
    {
        $this->mock->shouldReceive('getByUsername')->once()->with([])->andReturn('username');
        $this->assertResponseOk($this->action('GET', 'Admin\AuthController@login'));
    }
}
*/