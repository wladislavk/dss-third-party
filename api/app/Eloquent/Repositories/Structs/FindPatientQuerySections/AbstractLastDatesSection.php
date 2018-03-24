<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

abstract class AbstractLastDatesSection extends AbstractAdvanceOrderingSection
{
    public function getJoinSQL()
    {
        return <<<SQL
LEFT JOIN (
  SELECT base_last_dates.patientid, MAX(base_last_dates.id) AS max_id, base_last_dates.segmentid
  FROM dental_flow_pg2_info base_last_dates
  INNER JOIN (
    SELECT patientid, max(date_completed) AS max_date
    FROM dental_flow_pg2_info
    GROUP BY patientid
  ) pivot_last_dates 
  ON pivot_last_dates.patientid = base_last_dates.patientid
  AND pivot_last_dates.max_date = base_last_dates.date_completed
  GROUP BY base_last_dates.patientid
) last_dates_pivot ON last_dates_pivot.patientid = p.patientid
LEFT JOIN dental_flow_pg2_info last_dates ON last_dates.id = last_dates_pivot.max_id
SQL;
    }
}
