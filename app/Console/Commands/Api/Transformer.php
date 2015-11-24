<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class Transformer extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'api:transformers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new api transformers class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Transformer Api';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/transformer.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Transformers\Api';
    }

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $name = str_replace('Transformer', '', $class);

        $stub =  str_replace('DummyName', $name, $stub);

        $name[0] = strtolower($name[0]);
        $stub =  str_replace('DummyParamName', '$'.snake_case($name), $stub);

        return $stub;
    }
}

