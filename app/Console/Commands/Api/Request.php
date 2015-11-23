<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class Request extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'api:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new api form request class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request Api';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/request.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Requests\Api';
    }
}
