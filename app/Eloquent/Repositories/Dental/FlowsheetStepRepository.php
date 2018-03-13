<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetStep;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class FlowsheetStepRepository extends AbstractRepository
{
    public function model()
    {
        return FlowsheetStep::class;
    }

    /**
     * @param int $section
     * @return array
     */
    public function getStepsByRank(int $section = 1): array
    {
        $steps = $this->model
            ->where('section', $section)
            ->orderBy('sort_by')
            ->get()
            ->toArray()
        ;
        foreach ($steps as $key => $step) {
            $steps[$key]['rank'] = $key + 1;
        }
        return $steps;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getStepsByNext(int $id): array
    {
        $next_sql = $this->model
            ->select('steps.*')
            ->from(\DB::raw('dental_flowsheet_steps steps'))
            ->join(\DB::raw('dental_flowsheet_steps_next next'), 'steps.id', '=', 'next.child_id')
            ->where('next.parent_id', $id)
            ->orderBy('next.sort_by')
        ;
        return $next_sql->get()->toArray();
    }
}
