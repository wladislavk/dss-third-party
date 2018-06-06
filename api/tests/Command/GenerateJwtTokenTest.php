<?php

namespace Tests\Command;

use Carbon\Carbon;
use DentalSleepSolutions\Console\Commands\GenerateJwtToken;
use DentalSleepSolutions\Services\Auth\JwtHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCases\ApiTestCase;
use Tests\TestCases\BaseApiTestCase;
use Tests\TestCases\JwtAuthenticationMiddlewareTestCase;

class GenerateJwtTokenTest extends BaseApiTestCase
{
    public const ADMIN_ID = 1;
    public const USER_ID = 1;
    public const PATIENT_ID = 1;
    public const TOKEN_REGEXP = '/' . JwtAuthenticationMiddlewareTestCase::TOKEN_REGEXP . '/';

    /** @var string */
    private $expire;

    /** @var string */
    private $notBefore;

    /** @var GenerateJwtToken */
    private $command;

    /** @var BufferedOutput */
    private $output;

    public function setUp()
    {
        parent::setUp();

        $this->expire = '';
        $this->notBefore = '';

        /** @var GenerateJwtToken */
        $this->command = $this->app->make(GenerateJwtToken::class);
        $this->command->setLaravel($this->app);
        $this->output = new BufferedOutput();
    }

    public function testInvalidRole()
    {
        $role = 'none';
        $id = 0;
        $token = $this->runCommand($role, $id, $this->expire, $this->notBefore);
        $this->assertEquals('', $token);
    }

    public function testInvalidId()
    {
        $role = JwtHelper::ROLE_USER;
        $id = 0;
        $token = $this->runCommand($role, $id, $this->expire, $this->notBefore);
        $this->assertEquals('', $token);
    }

    public function testAdminId()
    {
        $role = JwtHelper::ROLE_ADMIN;
        $id = self::ADMIN_ID;
        $token = $this->runCommand($role, $id, $this->expire, $this->notBefore);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    public function testUserId()
    {
        $role = JwtHelper::ROLE_USER;
        $id = self::USER_ID;
        $token = $this->runCommand($role, $id, $this->expire, $this->notBefore);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    public function testPatientId()
    {
        $role = JwtHelper::ROLE_PATIENT;
        $id = self::PATIENT_ID;
        $token = $this->runCommand($role, $id, $this->expire, $this->notBefore);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    public function testExpireOption()
    {
        $role = JwtHelper::ROLE_USER;
        $id = self::USER_ID;
        $this->expire = $this->date(1);
        $token = $this->runCommand($role, $id, $this->expire, $this->notBefore);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    public function testNotBeforeOption()
    {
        $role = JwtHelper::ROLE_USER;
        $id = self::USER_ID;
        $this->notBefore = $this->date(-1);
        $token = $this->runCommand($role, $id, $this->expire, $this->notBefore);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    /**
     * @param string $role
     * @param int $id
     * @param string $expire
     * @param string $notBefore
     * @return string
     */
    private function runCommand(string $role, int $id, string $expire, string $notBefore): string
    {
        $options = [
            'role' => $role,
            'id' => $id,
        ];

        if ($expire) {
            $options['--expire'] = $expire;
        }

        if ($notBefore) {
            $options['--not-before'] = $notBefore;
        }

        $input = new ArrayInput($options);
        $this->command->run($input, $this->output);
        $result = $this->output->fetch();

        return trim($result);
    }

    /**
     * @param int $yearOffset
     * @return string
     */
    private function date(int $yearOffset = 0): string
    {
        return Carbon::now()
            ->addYears($yearOffset)
            ->toDateTimeString()
        ;
    }
}
