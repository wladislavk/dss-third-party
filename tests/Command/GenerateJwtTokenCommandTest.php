<?php

namespace Tests\Command;

use DentalSleepSolutions\Console\Commands\GenerateJwtToken;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\User;
use DentalSleepSolutions\Auth\Legacy;

class GenerateJwtTokenCommandTest extends ApiTestCase
{
    const INVALID_ID = '-';
    const USER_ID = User::USER_PREFIX . '1';
    const ADMIN_ID = User::ADMIN_PREFIX . '1';

    const BASE_64_REGEXP = '[a-z\d\+\/]+';
    const TOKEN_REGEXP = '/' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '\.' . self::BASE_64_REGEXP . '/i';

    /** @var GenerateJwtToken */
    private $command;

    /** @var BufferedOutput */
    private $output;

    /** @var Legacy */
    private $legacyMock;

    public function setUp()
    {
        parent::setUp();

        /** @var GenerateJwtToken */
        $this->command = $this->app->make(GenerateJwtToken::class);
        $this->command->setLaravel($this->app);
        $this->output = new BufferedOutput();
        $this->legacyMock = $this->mockLegacyAuth();
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

    public function testCompositeToken()
    {
        $options = ['id' => $this->legacyMock->composeId(self::ADMIN_ID, self::USER_ID)];
        $input = new ArrayInput($options);
        $this->command->run($input, $this->output);
        $result = $this->output->fetch();

        $this->assertRegExp(self::TOKEN_REGEXP, $result);
    }

    private function mockLegacyAuth()
    {
        $mock = $this->getMockBuilder(Legacy::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $mock;
    }
}
