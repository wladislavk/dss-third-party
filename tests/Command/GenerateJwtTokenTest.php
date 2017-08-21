<?php

namespace Tests\Command;

use Carbon\Carbon;
use DentalSleepSolutions\Console\Commands\GenerateJwtToken;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCases\ApiTestCase;

class GenerateJwtTokenTest extends ApiTestCase
{
    const INVALID_ID = '-';
    const USER_ID = 'u_1';
    const ADMIN_ID = 'a_1';

    const BASE_64_REGEXP = '[a-z\d\+\/\_\-]+';
    const TOKEN_REGEXP = '/' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '/i';

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

    public function testInvalidId()
    {
        $id = self::INVALID_ID;
        $token = $this->runCommand($id, $this->expire, $this->notBefore);
        $this->assertEquals('', $token);
    }

    public function testUserId()
    {
        $id = self::USER_ID;
        $token = $this->runCommand($id, $this->expire, $this->notBefore);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    public function testAdminId()
    {
        $id = self::ADMIN_ID;
        $token = $this->runCommand($id, $this->expire, $this->notBefore);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    public function testExpireOption()
    {
        $id = self::USER_ID;
        $this->expire = $this->date(1);
        $token = $this->runCommand($id, $this->expire, $this->notBefore);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    public function testNotBeforeOption()
    {
        $id = self::USER_ID;
        $this->notBefore = $this->date(-1);
        $token = $this->runCommand($id, $this->expire, $this->notBefore);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    private function runCommand($id, $expire, $notBefore)
    {
        $options = ['id' => $id];

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

    private function date($yearOffset = 0)
    {
        return Carbon::now()
            ->addYears($yearOffset)
            ->toDateTimeString()
        ;
    }
}
