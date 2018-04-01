<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\FlowsheetStep;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Support\Collection;

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
    public function getStepsByRank(int $section = 0): array
    {
        $query = $this->model
            ->orderBy('section')
            ->orderBy('sort_by')
        ;
        if ($section) {
            $query->where('section', $section);
        }
        $steps = $query->get()->toArray();
        foreach ($steps as $key => $step) {
            $steps[$key]['rank'] = $key + 1;
        }
        return $steps;
    }
    /**
     * @param int $id
     * @return FlowsheetStep[]|Collection
     */
    public function getStepsByNext(int $id): iterable
    {
        $query = $this->model
            ->select('steps.*')
            ->from(\DB::raw('dental_flowsheet_steps steps'))
            ->join(\DB::raw('dental_flowsheet_steps_next next'), 'steps.id', '=', 'next.child_id')
            ->where('next.parent_id', $id)
            ->orderBy('next.sort_by')
        ;
        return $query->get();
    }
}
