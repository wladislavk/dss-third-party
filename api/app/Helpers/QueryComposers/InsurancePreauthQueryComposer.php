<?php

namespace DentalSleepSolutions\Helpers\QueryComposers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\InsurancePreauthRepository;
use DentalSleepSolutions\Structs\ListVOBQueryData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class InsurancePreauthQueryComposer
{
    /** @var InsurancePreauthRepository */
    private $insurancePreauthRepository;

    public function __construct(InsurancePreauthRepository $insurancePreauthRepository)
    {
        $this->insurancePreauthRepository = $insurancePreauthRepository;
    }

    /**
     * @param ListVOBQueryData $data
     * @return array
     */
    public function composeGetListVobsQuery(ListVOBQueryData $data) {

        $query = $this->insurancePreauthRepository->getListVobsBaseQuery($data);
        if ($data->viewed !== null) {
            $query = $this->setPreauthViewed($query, $data->viewed);
        }
        $newSortColumn = $this->changeSortColumn($data->sortColumn);
        $query = $this->insurancePreauthRepository
            ->getListVobsSetOrderBy($query, $newSortColumn, $data->sortDir);

        return $this->insurancePreauthRepository->getPagedResult($query, $data->offset, $data->vobsPerPage);
    }

    /**
     * @param Builder|QueryBuilder $query
     * @param bool $viewed
     * @return Builder|QueryBuilder
     */
    private function setPreauthViewed($query, $viewed)
    {
        if ($viewed) {
            return $this->insurancePreauthRepository
                ->getListVobsSetPreauthViewedWithViewed($query);
        }
        return $this->insurancePreauthRepository
            ->getListVobsSetPreauthViewedWithoutViewed($query);
    }

    /**
     * @param string $sortColumn
     * @return string
     */
    private function changeSortColumn($sortColumn)
    {
        if (array_key_exists($sortColumn, InsurancePreauthRepository::COLUMN_CHANGE_RULES)) {
            return InsurancePreauthRepository::COLUMN_CHANGE_RULES[$sortColumn];
        }

        return $sortColumn;
    }
}
