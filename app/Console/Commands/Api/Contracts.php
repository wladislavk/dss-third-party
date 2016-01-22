<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class Contracts extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'api:contracts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repo and resource contracts';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Api Contracts';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $resource = Str::studly(Str::singular($this->argument('resource')));
        $this->create('Resource', $this->laravel->getNamespace().'Contracts\Resources\\'.$resource);

        $repository = Str::plural($resource);
        $this->create('Repository', $this->laravel->getNamespace().'Contracts\Repositories\\'.$repository);
    }

    /**
     * Create single contract for a resource.
     *
     * @param  string $base
     * @param  string $name
     * @return void
     */
    protected function create($base, $name)
    {
        $path = $this->getPath($name);

        if ($this->files->exists($path)) {
            $this->warn($name.' already exists, skipping.');

            return;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->build($base, $name));

        $this->info($base.' contract created successfully.');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string $base
     * @param  string $name
     * @return string
     */
    protected function build($base, $name)
    {
        $stub = parent::buildClass($name);

        return str_replace('BaseInterface', $base, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/contract.stub';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['resource', InputArgument::REQUIRED, 'The name of the resource'],
        ];
    }
}
