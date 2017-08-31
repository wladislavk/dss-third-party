<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class NextVisitSection extends AbstractAdvanceOrderingSection
{
    public function getSelectSQL()
    {
        return <<<SQL
next_visit.date_scheduled AS date_scheduled
SQL;
    }

    public function getJoinSQL()
    {
        return <<<SQL
LEFT JOIN (
  SELECT patientid, MAX(id) AS max_id
  FROM dental_flow_pg2_info
  WHERE appointment_type = 0
  GROUP BY patientid
) next_visit_pivot ON next_visit_pivot.patientid = p.patientid
LEFT JOIN dental_flow_pg2_info next_visit ON next_visit.id = next_visit_pivot.max_id
SQL;
    }

    protected function getInnerOrderSQL($dir)
    {
        return <<<SQL
date_scheduled $dir
SQL;
    }
}
