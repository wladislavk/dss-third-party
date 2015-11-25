<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Schema\Builder;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Requests extends GeneratorCommand
{
    protected $types = ['Store', 'Update', 'Destroy'];

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

    public function __construct(Filesystem $files, Builder $schema)
    {
        parent::__construct($files);

        $this->schema = $schema;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $resource = Str::studly(Str::singular($this->argument('resource')));

        foreach ($this->types as $type) {
            $this->create($type.$resource);
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

        $this->info($request.' created successfully.');
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
        $rules = '';

        try {
            if ($table = $this->resourceTable()) {
                $columns = $this->schema->getColumnListing($table);

                $rules = trim(array_reduce($columns, function ($rules, $column) {
                    return $rules .= "            '{$column}' => '',\n";
                }, ''), "\n");
            }
        } catch (Exception $e) {
            //
        }

        $rules = $rules ?: '            // @todo Provide validation rules';

        return str_replace('rules_placeholder', $rules, $stub);
    }

    protected function resourceTable()
    {
        return 'migrations';

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
