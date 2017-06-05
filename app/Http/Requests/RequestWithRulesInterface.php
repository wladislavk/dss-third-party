<?php

namespace DentalSleepSolutions\Http\Requests;

interface RequestWithRulesInterface
{
    /**
     * @return array
     */
    public function rules();
}
