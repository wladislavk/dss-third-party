<?php

namespace DentalSleepSolutions\Services\Misc\ThirdPartyCallers;

use GuzzleHttp\Client;

class GuzzleCaller implements ThirdPartyCallerInterface
{
    /** @var Client */
    private $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $method
     * @param string $path
     * @param string[] $headers
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callApi(string $method, string $path, array $headers): string
    {
        $response = $this->guzzleClient->request($method, $path, $headers);
        return $response->getBody()->getContents();
    }
}
