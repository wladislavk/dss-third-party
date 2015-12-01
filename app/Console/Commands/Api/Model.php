<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class Model extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'api:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Eloquent';
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $class = class_basename($name);
        $repo = Str::plural($class);

        $stub = $this->replaceRepo($stub, $repo);

        return $this->replaceOptions($stub, $class);
    }

    /**
     * Replace repository name for the given stub.
     *
     * @param  string $stub
     * @param  string $repo
     * @return string
     */
    protected function replaceRepo($stub, $repo)
    {
        return str_replace('DummyRepo', $repo, $stub);
    }

    /**
     * Replace the table name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $class
     * @return string
     */
    protected function replaceOptions($stub, $class)
    {
        $table = $this->option('table') ?: Str::snake(Str::plural($class));

        $id = $this->option('pk');

        return str_replace(['dummy_table', 'dummy_id'], [$table, $id], $stub);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['table', 't', InputOption::VALUE_OPTIONAL, 'Table name for the model.'],
            ['pk', 'k', InputOption::VALUE_OPTIONAL, 'Primary key field on the table.', 'id'],
        ];
    }
}
