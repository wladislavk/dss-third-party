<?php

namespace Tests\TestCases;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;

class BaseApiTestCase extends BaseTestCase
{
    const ROUTE_PREFIX = '/api/v1';

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function getResponseData()
    {
        $content = json_decode($this->response->getContent(), true);
        return $content['data'];
    }
}
