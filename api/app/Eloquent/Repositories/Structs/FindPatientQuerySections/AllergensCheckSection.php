<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class AllergensCheckSection extends AbstractSection
{
    public function getSelectSQL()
    {
        return '';
    }

    public function getJoinSQL()
    {
        return <<<SQL
LEFT JOIN (
  SELECT patientid, MAX(q_page3id) AS max_id
  FROM dental_q_page3
  GROUP BY patientid
) allergens_check_pivot ON allergens_check_pivot.patientid = p.patientid
LEFT JOIN dental_q_page3 allergens_check ON allergens_check.q_page3id = allergens_check_pivot.max_id
SQL;
    }

    public function getOrderSQL($dir)
    {
        return '';
    }
}
