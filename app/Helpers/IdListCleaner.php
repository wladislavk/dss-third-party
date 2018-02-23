<?php

namespace DentalSleepSolutions\Helpers;

class IdListCleaner
{
    /**
     * @param string|null $stringList
     * @return null|string|string[]
     */
    public function clearIdList($stringList = null)
    {
        if (!$stringList === null) {
            return null;
        }
        $stringList = preg_replace('/,+/', ',', $stringList);
        // Add a default value here
        if ($stringList === '' || $stringList === ',') {
            return null;
        }
        return $stringList;
    }
}
