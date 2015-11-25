<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Support\Str;
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
    protected $description = 'Create a new api Controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Api Controller';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        parent::fire();

        $this->bindResourceToRoute();
    }

    /**
     * Create new entry for the route model bindings.
     *
     * @return void
     */
    protected function bindResourceToRoute()
    {
        $path = $this->laravel['path'].'/Providers/RouteServiceProvider.php';

        if (!$this->files->exists($path)) {
            $this->warn("Couldn't bind resource to route - file not found: {$path}");

            return;
        }

        $class = '\\'.$this->laravel->getNamespace().'Eloquent\\'.$this->getResourceName();

        $key = Str::camel(Str::plural($this->getResourceName()));

        $provider = str_replace(
            ['protected $resourceBindings = [', ',]'],
            ["protected \$resourceBindings = [\n        '{$key}' => {$class}::class,", ",\n    ]"],
            $this->files->get($path)
        );

        $this->files->put($path, $provider);

        $this->info('Resource bound to route.');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        return $this->replaceResource($stub);
    }

    /**
     * Replace the table name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $controller
     * @return string
     */
    protected function replaceResource($stub)
    {
        $resource = $this->getResourceName();

        $repository = Str::plural($resource);

        return str_replace(['DummyRepository', 'DummyResource'], [$repository, $resource], $stub);
    }

    /**
     * Guess resource class name from the provided controller name.
     *
     * @return string
     */
    protected function getResourceName()
    {
        $controller = $this->parseName($this->getNameInput());

        $base = str_replace('Controller', '', class_basename($controller));

        return Str::singular($base);
    }

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
