<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Requests extends GeneratorCommand
{
    protected $rules = '';
    protected $actions = ['Store', 'Update', 'Destroy'];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'api:requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a set of self-validating request classes for a resource';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Api Requests';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $resource = Str::studly(Str::singular($this->argument('resource')));

        foreach ($this->actions as $action) {
            $this->create($resource.$action);
        }
    }

    protected function create($request)
    {
        $name = $this->parseName($request);

        $path = $this->getPath($name);

        if ($this->files->exists($path)) {
            $this->warn($request.' already exists, skipping.');

            return;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($request.' request created successfully.');
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

        return $this->replaceRules($stub);
    }

    /**
     * Replace the table name for the given stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function replaceRules($stub)
    {
        if ($this->rules) {
            return str_replace('rules_placeholder', $this->rules, $stub);
        }

        try {
            if ($table = $this->resourceTable()) {
                $columns = $this->laravel['db']->connection()->getSchemaBuilder()->getColumnListing($table);

                $this->rules = trim(array_reduce($columns, function ($rules, $column) {
                    return $rules .= "            '{$column}' => '',\n";
                }, ''), "\n");
            }
        } catch (Exception $e) {
            //
        }

        $this->rules = $this->rules ?: '            // @todo Provide validation rules';

        return str_replace('rules_placeholder', $this->rules, $stub);
    }

    protected function resourceTable()
    {
        $resource = $this->laravel->getNamespace().'\Eloquent\\'.Str::singular($this->argument('resource'));

        if (class_exists($resource) && $resource instanceof Eloquent) {
            return (new $resource)->getTable();
        }
    }

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
        return $rootNamespace.'\Http\Requests';
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
