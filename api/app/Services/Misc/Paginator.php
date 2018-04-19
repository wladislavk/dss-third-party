<?php

namespace DentalSleepSolutions\Services\Misc;

use DentalSleepSolutions\Exceptions\GeneralException;
use Illuminate\Database\Eloquent\Collection;

class Paginator
{
    /**
     * @param Collection|array $collection
     * @param int $page
     * @param int $recordsPerPage
     * @return Collection|array
     * @throws GeneralException
     */
    public function limitResultToPage($collection, $page, $recordsPerPage)
    {
        if ($recordsPerPage <= 0) {
            return $collection;
        }
        if ($page < 1) {
            $page = 1;
        }
        $start = ($page - 1) * $recordsPerPage;
        if (is_array($collection)) {
            return array_slice($collection, $start, $recordsPerPage);
        }
        if ($collection instanceof Collection) {
            return $collection->slice($start, $recordsPerPage);
        }
        throw new GeneralException('Collection must be either array or object of type ' . Collection::class);
    }
}
