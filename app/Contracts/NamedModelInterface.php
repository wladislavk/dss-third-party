<?php

namespace DentalSleepSolutions\Contracts;

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
