<?php

namespace DentalSleepSolutions\Console\Commands\Api;

use Illuminate\Console\Command;

class Rest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:rest {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create rest classes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        //controller
        $this->call('api:controller', array('name' => $name . 'Controller'));

        //route
        $this->call('api:route', array('controller' => $name . 'Controller'));

        //model
        $this->call('api:model', array('name' => $name));

        //form requests
        $this->call('api:request', array('name' => $name . '/Create' . $name . 'Request'));
        $this->call('api:request', array('name' => $name . '/Update' . $name . 'Request'));

        //transformer
        $this->call('api:transformer', array('name' => $name . 'Transformer'));

    }
}
