<?php

namespace DentalSleepSolutions\Console\Commands;

use DentalSleepSolutions\Swagger\Generator;
use Illuminate\Console\Command;

class GenerateSwaggerCommand extends Command
{
    /** @var string */
    protected $signature = 'swagger:generate
                            {--http-dir= : Path to root of requests and controllers, /app/Http by default}
                            {--model-dir= : Path to root of Eloquent models, /Eloquent by default }';

    protected $description = 'Generate Swagger annotations from existing models and request rules';

    /** @var Generator */
    private $generator;

    public function __construct(Generator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    public function handle()
    {
        $httpDir = $this->option('http-dir');
        $modelDir = $this->option('model-dir');
        if (!$httpDir || !$modelDir) {
            $this->generator->generateSwagger();
        } else {
            $this->generator->generateSwagger($httpDir, $modelDir);
        }
        $this->info('Swagger documentation generated');
    }
}
