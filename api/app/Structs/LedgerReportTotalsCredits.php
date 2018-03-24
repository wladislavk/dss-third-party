<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Database\Eloquent\Collection;

class LedgerReportTotalsCredits
{
    /** @var array|Collection */
    public $type;

    /** @var array|Collection */
    public $named;

    public function toArray()
    {
        return [
            'type' => $this->type,
            'named' => $this->named,
        ];
    }
}
