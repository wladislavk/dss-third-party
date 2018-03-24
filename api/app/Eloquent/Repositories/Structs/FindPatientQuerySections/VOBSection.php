<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class VOBSection extends AbstractAdvanceOrderingSection
{
    public function getSelectSQL()
    {
        return <<<SQL
summary.vob AS vob
SQL;
    }

    public function getJoinSQL()
    {
        return <<<SQL
LEFT JOIN dental_patient_summary summary ON summary.pid = p.patientid
SQL;
    }

    protected function getInnerOrderSQL($dir)
    {
        return <<<SQL
vob $dir
SQL;
    }
}
