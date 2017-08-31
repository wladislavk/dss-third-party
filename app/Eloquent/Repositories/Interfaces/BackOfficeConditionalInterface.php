<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Interfaces;

interface BackOfficeConditionalInterface
{
    /**
     * @param string $claimAlias
     * @return string
     */
    public function filedByBackOfficeConditional($claimAlias);
}
