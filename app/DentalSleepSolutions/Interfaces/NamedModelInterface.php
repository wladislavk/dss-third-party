<?php

namespace DentalSleepSolutions\DentalSleepSolutions\Interfaces;

interface NamedModelInterface
{
    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string|null
     */
    public function getMiddleName();

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @return string
     */
    public function getLabel();
}
