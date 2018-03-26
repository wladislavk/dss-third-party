<?php

namespace DentalSleepSolutions\Wrappers;

use function hash_equals;

class HashWrapper
{
    /**
     * @param string $algorithm
     * @param string $data
     * @param bool $rawOutput
     * @return string
     */
    public function hash($algorithm, $data, $rawOutput = false)
    {
        return hash($algorithm, $data, $rawOutput);
    }

    /**
     * @param string $knownString
     * @param string $userString
     * @return bool
     */
    public function hashEquals($knownString, $userString)
    {
        return hash_equals($knownString, $userString);
    }

    public function sha1($string)
    {
        return sha1($string);
    }
}
