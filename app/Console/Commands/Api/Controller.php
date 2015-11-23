<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class Controller extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'api:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new api controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller Api';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers\Api';
    }
}

