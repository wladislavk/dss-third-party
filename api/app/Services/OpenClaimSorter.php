<?php

namespace DentalSleepSolutions\Services;

class OpenClaimSorter
{
    const SORT_COLUMNS = [
        'entry_date'  => 'entry_date',
        'producer'    => 'name',
        'patient'     => 'lastname',
        'description' => 'description',
        'amount'      => 'amount',
        'paid_amount' => 'paid_amount',
        'status'      => 'status',
    ];

    const DEFAULT_SORT_COLUMN = 'service_date';

    /**
     * @param string $sort
     * @return string
     */
    public function getSortColumnForList($sort)
    {
        $sortColumn = self::DEFAULT_SORT_COLUMN;
        if (array_key_exists($sort, self::SORT_COLUMNS)) {
            $sortColumn = self::SORT_COLUMNS[$sort];
        }

        return $sortColumn;
    }
}
