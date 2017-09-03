<?php

namespace Tests\TestCases;

use DentalSleepSolutions\Http\Requests\Request;

class BaseApiTestCase extends BaseIntegrationTestCase
{
    const ROUTE_PREFIX = '/api/v1';

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected function getResponseData()
    {
        $content = json_decode($this->response->getContent(), true);
        return $content['data'];
    }

    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');

        $this->currentUri = $this->prepareUrlForRequest($uri);

        $request = Request::create(
            $this->currentUri, $method, $parameters,
            $cookies, $files, array_replace($this->serverVariables, $server), $content
        );

        $response = $kernel->handle($request);

        $kernel->terminate($request, $response);

        return $this->response = $response;
    }
}
