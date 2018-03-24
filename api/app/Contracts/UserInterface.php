<?php

namespace DentalSleepSolutions\Contracts;

interface UserInterface
{
    /**
     * @return int
     */
    public function getDocIdOrZero();

    /**
     * @return int
     */
    public function getUserIdOrZero();

    /**
     * @return int
     */
    public function getUserTypeOrZero();
}
