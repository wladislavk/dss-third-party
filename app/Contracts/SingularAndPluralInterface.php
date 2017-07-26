<?php

namespace DentalSleepSolutions\Contracts;

interface SingularAndPluralInterface
{
    /**
     * @return string
     */
    public function getSingular();

    /**
     * @return string
     */
    public function getPlural();
}
