<?php

namespace DentalSleepSolutions\Helpers;

class IdListCleaner
{
    /**
     * @param string|null $stringList
     * @return null|string
     */
    public function clearIdList(?string $stringList = null): ?string
    {
        if ($stringList === null) {
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
