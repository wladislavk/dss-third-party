<?php

namespace DentalSleepSolutions\StaticClasses;

class Helpers
{
    /**
     * Returns sorted array while leaving the original unchanged
     *
     * @param array $array
     * @return array
     */
    public static function saneSort(array $array)
    {
        $secondArray = $array;
        sort($secondArray);
        return $secondArray;
    }
}
