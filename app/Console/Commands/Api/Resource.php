<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class Resource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:resource {resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup complete REST resource: CRUD endpoints, controller, model, transformer & requests';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $resource   = Str::studly(Str::singular($this->argument('resource')));
        $controller = Str::plural($resource).'Controller';

        $this->call('api:controller', ['name' => $controller]);
        $this->call('api:route', ['controller' => $controller]);
        $this->call('api:model', ['name' => $resource]);
        $this->call('api:requests', ['resource' => $resource]);
        $this->call('api:transformer', ['resource' => $resource]);
    }
}
