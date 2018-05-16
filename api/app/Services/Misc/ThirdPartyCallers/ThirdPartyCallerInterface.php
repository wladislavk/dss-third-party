<?php

namespace DentalSleepSolutions\Services\Misc\ThirdPartyCallers;

interface ThirdPartyCallerInterface
{
    /**
     * @param string $method
     * @param string $path
     * @param string[] $headers
     * @return string
     */
    public function callApi(string $method, string $path, array $headers): string;
}
