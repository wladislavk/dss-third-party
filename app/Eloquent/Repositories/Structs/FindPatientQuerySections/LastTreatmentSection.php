<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class LastTreatmentSection extends AbstractLastDatesSection
{
    public function getSelectSQL()
    {
        return <<<SQL
last_dates.segmentid AS segmentid
SQL;
    }

    protected function getInnerOrderSQL($dir)
    {
        return <<<SQL
segmentid $dir
SQL;
    }
}
