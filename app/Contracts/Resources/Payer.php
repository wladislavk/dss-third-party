<?php

namespace DentalSleepSolutions\Contracts\Resources;

interface Payer extends Resource
{
    /**
     * Get enrollment required fields for a payer.
     *
     * @return string[]
     */
    public function requiredFields($endpoint = null);
}
