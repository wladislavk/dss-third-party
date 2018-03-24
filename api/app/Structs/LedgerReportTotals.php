<?php

namespace DentalSleepSolutions\Structs;

use Illuminate\Database\Eloquent\Collection;

class LedgerReportTotals
{
    /** @var array|Collection */
    public $charges = [];

    /** @var array|Collection|LedgerReportTotalsCredits */
    public $credits;

    /** @var array|Collection */
    public $adjustments = [];

    public function toArray()
    {
        $credits = $this->credits;
        if ($credits instanceof LedgerReportTotalsCredits) {
            $credits = $credits->toArray();
        }
        return [
            'charges'     => $this->charges,
            'credits'     => $credits,
            'adjustments' => $this->adjustments,
        ];
    }
}
