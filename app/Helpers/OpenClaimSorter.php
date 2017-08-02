<?php

namespace DentalSleepSolutions\Helpers;

class OpenClaimSorter
{
    /**
     * @param string $sort
     * @return string
     */
    public function getSortColumnForList($sort)
    {
        $sortColumns = [
            'entry_date'  => 'entry_date',
            'producer'    => 'name',
            'patient'     => 'lastname',
            'description' => 'description',
            'amount'      => 'amount',
            'paid_amount' => 'paid_amount',
            'status'      => 'status',
        ];

        $sortColumn = 'service_date';
        if (array_key_exists($sort, $sortColumns)) {
            $sortColumn = $sortColumns[$sort];
        }

        return $sortColumn;
    }
}
