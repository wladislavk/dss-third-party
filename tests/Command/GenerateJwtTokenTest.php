<?php

namespace Tests\Command;

use DentalSleepSolutions\Console\Commands\GenerateJwtToken;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCases\ApiTestCase;

class GenerateJwtTokenTest extends ApiTestCase
{
    const INVALID_ID = '-';
    const VALID_ID = 'u_1';

    const BASE_64_REGEXP = '[a-z\d\+\/\_\-]+';
    const TOKEN_REGEXP = '/' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '/i';

    /** @var GenerateJwtToken */
    private $command;

    /** @var BufferedOutput */
    private $output;

    public function setUp()
    {
        parent::setUp();

        /** @var GenerateJwtToken */
        $this->command = $this->app->make(GenerateJwtToken::class);
        $this->command->setLaravel($this->app);
        $this->output = new BufferedOutput();
    }

    public function testInvalidToken()
    {
        $id = self::INVALID_ID;
        $token = $this->runCommand($id);
        $this->assertEquals('', $token);
    }

    public function testValidToken()
    {
        $id = self::USER_ID;
        $token = $this->runCommand($id);
        $this->assertRegExp(self::TOKEN_REGEXP, $token);
    }

    private function runCommand($id)
    {
        $options = ['id' => $id];
        $input = new ArrayInput($options);
        $this->command->run($input, $this->output);
        $result = $this->output->fetch();

        return trim($result);
    }
}
