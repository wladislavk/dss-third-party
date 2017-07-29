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

    /**
     * @dataProvider jwtTokenDataProvider
     */
    public function testGenerateJwtToken($userId, $expectedResult)
    {
        $options = ['id' => $userId];
        $input = new ArrayInput($options);
        $this->command->run($input, $this->output);
        $result = $this->output->fetch();
        $this->assertThat($result, $expectedResult);
    }

    public function jwtTokenDataProvider()
    {
        $base64Regexp = '[a-z\d\+\/]+';
        $isNotEmpty = $this->matchesRegularExpression("/$base64Regexp\.$base64Regexp\.$base64Regexp/i");
        $isEmpty = $this->equalTo('');

        return [
            [self::INVALID_ID, $isEmpty],
            [self::USER_ID, $isNotEmpty],
            [$this->compositeId(self::ADMIN_ID, self::USER_ID), $isNotEmpty],
        ];
    }
    
    private function compositeId($firstId, $secondId)
    {
        return join(Legacy::LOGIN_ID_DELIMITER, [$firstId, $secondId]);
    }
}
