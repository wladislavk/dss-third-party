<?php

namespace DentalSleepSolutions\Services\Misc\ThirdPartyCallers;

// this class is to be used in testing env only, so the rule of not keeping information
// on service properties can be violated
class MockCaller implements ThirdPartyCallerInterface
{
    /** @var string */
    private $expectedResponse = '{}';

    /**
     * @param string $response
     */
    public function setExpectedResponse(string $response): void
    {
        $this->expectedResponse = $response;
    }

    /**
     * @param string $method
     * @param string $path
     * @param string[] $headers
     * @return string
     */
    public function callApi(string $method, string $path, array $headers): string
    {
        return $this->expectedResponse;
    }
}
