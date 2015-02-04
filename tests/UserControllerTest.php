<?php
//
//class UserControllerTest extends TestCase
//{
//    public function setUp()
//    {
//        parent::setUp();
//
//        $this->mock = $this->mock('Ds3\Admin\Repositories\UserRepository');
//    }
//    public function mock($class)
//    {
//        $mock = Mockery::mock($class);
//        $this->app->instance($class, $mock);
//
//        return $mock;
//    }
//    public function tearDown()
//    {
//        Mockery::close();
//    }
//    public function testIndex()
//    {
//        $this->mock->shouldReceive('getAllUsers')->once()->andReturn('users');
//    }
//
//
//}