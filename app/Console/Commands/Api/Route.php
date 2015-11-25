<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class Route extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:route {controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create REST routing entry for a controller.';

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = $this->laravel['path'].'/Http/routes.php';

        $controller = $this->parseName($this->argument('controller'));

        if (!$this->check($path, $resource = $this->resourceName($controller))) {
            return false;
        }

        $current = $this->files->get($path);

        $updated = preg_replace(
            "#^(\h*).+'prefix' => 'api/v.+$#m",
            "$0\n\n$1    Route::resource('{$resource}', '{$controller}');",
            $current,
            1
        );

        $this->files->put($path, $updated);

        $this->info('REST route registered in routes.php');
    }

    /**
     * Check whether routes file is writable and resource is not already registered.
     *
     * @param  string $path
     * @param  string $resource
     * @return boolean
     */
    protected function check($path, $resource)
    {
        if (!$this->files->exists($path) || !$this->files->isWritable($path)) {
            $this->error('File routes.php is not writable or missing.');

            return false;
        }

        if (strpos($this->files->get($path), "Route::resource('{$resource}'") !== false) {
            $this->warn("Route already exists for resource [{$resource}].");

            return false;
        }

        return true;
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function parseName($name)
    {
        $rootNamespace = $this->laravel->getNamespace().'\Http\Controllers\\';

        if (Str::startsWith($name, $rootNamespace)) {
            return str_replace($rootNamespace, '', $name);
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->parseName($rootNamespace.$name);
    }

    /**
     * Guess resource url endpoint from the provided controller name.
     *
     * @param  string $controller
     * @return string
     */
    protected function resourceName($controller)
    {
        return Str::plural(Str::snake(str_replace('Controller', '', class_basename($controller)), '-'));
    }
}
