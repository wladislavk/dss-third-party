<?php

namespace Tests\Command;

use DentalSleepSolutions\Console\Commands\GenerateSwaggerCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCases\BaseApiTestCase;

class GenerateSwaggerCommandTest extends BaseApiTestCase
{
    const FIRST_MODEL = __DIR__ . '/../Dummies/Eloquent/FirstDummy.php';
    const SECOND_MODEL = __DIR__ . '/../Dummies/Eloquent/SecondDummy.php';
    const FIRST_CONTROLLER = __DIR__ . '/../Dummies/Http/Controllers/FirstDummiesController.php';
    const SECOND_CONTROLLER = __DIR__ . '/../Dummies/Http/Controllers/SecondDummiesController.php';

    const FIRST_EXPECTED_MODEL = __DIR__ . '/../Dummies/Expected/ExpectedFirstModel.txt';
    const SECOND_EXPECTED_MODEL = __DIR__ . '/../Dummies/Expected/ExpectedSecondModel.txt';
    const FIRST_EXPECTED_CONTROLLER = __DIR__ . '/../Dummies/Expected/ExpectedFirstController.txt';
    const SECOND_EXPECTED_CONTROLLER = __DIR__ . '/../Dummies/Expected/ExpectedSecondController.txt';

    private $firstModelContents = '';
    private $secondModelContents = '';
    private $firstControllerContents = '';
    private $secondControllerContents = '';

    public function setUp()
    {
        parent::setUp();

        $this->firstModelContents = file_get_contents(self::FIRST_MODEL);
        $this->secondModelContents = file_get_contents(self::SECOND_MODEL);
        $this->firstControllerContents = file_get_contents(self::FIRST_CONTROLLER);
        $this->secondControllerContents = file_get_contents(self::SECOND_CONTROLLER);
    }

    public function testGenerateSwagger()
    {
        $options = [
            '--http-dir' => 'tests/Dummies/Http',
            '--model-dir' => 'tests/Dummies/Eloquent',
        ];
        /** @var GenerateSwaggerCommand $command */
        $command = $this->app->make(GenerateSwaggerCommand::class);
        $command->setLaravel($this->app);
        $input = new ArrayInput($options);
        $output = new BufferedOutput();
        $command->run($input, $output);
        $result = $output->fetch();

        $this->assertContains('Swagger documentation generated', $result);

        $firstModelContents = file_get_contents(self::FIRST_MODEL);
        $firstModelExpectedContents = file_get_contents(self::FIRST_EXPECTED_MODEL);
        $this->assertEquals($firstModelExpectedContents, $firstModelContents);

        $secondModelContents = file_get_contents(self::SECOND_MODEL);
        $secondModelExpectedContents = file_get_contents(self::SECOND_EXPECTED_MODEL);
        $this->assertEquals($secondModelExpectedContents, $secondModelContents);

        $firstControllerContents = file_get_contents(self::FIRST_CONTROLLER);
        $firstControllerExpectedContents = file_get_contents(self::FIRST_EXPECTED_CONTROLLER);
        $this->assertEquals($firstControllerExpectedContents, $firstControllerContents);

        $secondControllerContents = file_get_contents(self::SECOND_CONTROLLER);
        $secondControllerExpectedContents = file_get_contents(self::SECOND_EXPECTED_CONTROLLER);
        $this->assertEquals($secondControllerExpectedContents, $secondControllerContents);
    }

    public function tearDown()
    {
        file_put_contents(self::FIRST_MODEL, $this->firstModelContents);
        file_put_contents(self::SECOND_MODEL, $this->secondModelContents);
        file_put_contents(self::FIRST_CONTROLLER, $this->firstControllerContents);
        file_put_contents(self::SECOND_CONTROLLER, $this->secondControllerContents);
    }
}
