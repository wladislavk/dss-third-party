<?php

namespace Tests\Command;

use DentalSleepSolutions\Console\Commands\GenerateJwtToken;
use DentalSleepSolutions\Helpers\SudoHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Repositories\UserRepository;

class GenerateJwtTokenTest extends ApiTestCase
{
    const INVALID_ID = '-';
    const USER_ID = SudoHelper::USER_PREFIX . '1';
    const ADMIN_ID = SudoHelper::ADMIN_PREFIX . '1';

    const BASE_64_REGEXP = '[a-z\d\+\/\_\-]+';
    const TOKEN_REGEXP = '/' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '/i';

    /** @var GenerateJwtToken */
    private $command;

    /** @var BufferedOutput */
    private $output;

    /** @var UserRepository */
    private $userRepository;

    public function setUp()
    {
        parent::setUp();

        /** @var GenerateJwtToken */
        $this->command = $this->app->make(GenerateJwtToken::class);
        $this->command->setLaravel($this->app);
        $this->output = new BufferedOutput();

        $this->userRepository = $this->app->make(UserRepository::class);
    }

    public function testInvalidToken()
    {
        $options = ['id' => self::INVALID_ID];
        $input = new ArrayInput($options);
        $this->command->run($input, $this->output);
        $result = $this->output->fetch();

        $this->assertEquals('', $result);
    }

    public function testSimpleToken()
    {
        $options = ['id' => self::USER_ID];
        $input = new ArrayInput($options);
        $this->command->run($input, $this->output);
        $result = $this->output->fetch();

        $this->assertRegExp(self::TOKEN_REGEXP, $result);
    }

    public function testSudoToken()
    {
        $options = ['id' => $this->userRepository->sudoId(self::ADMIN_ID, self::USER_ID)];
        $input = new ArrayInput($options);
        $this->command->run($input, $this->output);
        $result = $this->output->fetch();

        $this->assertRegExp(self::TOKEN_REGEXP, $result);
    }
}
