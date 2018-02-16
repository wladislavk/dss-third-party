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

    public function getStepsByRank($section = 1)
    {
        $steps = $this->model
            ->where('sectionid', $section)
            ->orderBy('sort_by')
            ->get()
            ->toArray()
        ;
        foreach ($steps as $key => $step) {
            $steps[$key]['rank'] = $key + 1;
        }
        return $steps;
    }
}
