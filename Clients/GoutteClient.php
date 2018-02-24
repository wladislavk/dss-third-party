<?php
namespace Clients;

use Goutte\Client;

class GoutteClient extends Client
{
    public function request($method, $uri, array $parameters = [], array $files = [], array $server = [], $content = null, $changeHistory = true)
    {
        $server['HTTP_ACCEPTANCE_TEST'] = '1';
        return parent::request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
    }
}
