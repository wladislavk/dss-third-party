<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class LastVisitSection extends AbstractLastDatesSection
{
    public function getSelectSQL()
    {
        return <<<SQL
last_dates.date_completed AS date_completed
SQL;
    }

    protected function getInnerOrderSQL($dir)
    {
        return <<<SQL
date_completed $dir
SQL;
    }
}
