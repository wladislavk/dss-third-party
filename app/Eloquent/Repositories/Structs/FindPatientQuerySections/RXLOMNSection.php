<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class RXLOMNSection extends AbstractAdvanceOrderingSection
{
    public function getSelectSQL()
    {
        return <<<SQL
CASE
  WHEN LENGTH(COALESCE(rx_lomn.rxlomnrec, ''))
  OR (
    LENGTH(COALESCE(rx_lomn.lomnrec, '')) AND LENGTH(COALESCE(rx_lomn.rxrec, ''))
  ) THEN 3
  WHEN LENGTH(COALESCE(rx_lomn.rxrec, '')) THEN 2
  WHEN LENGTH(COALESCE(rx_lomn.lomnrec, '')) THEN 1
  ELSE 0
END AS rx_lomn
SQL;
    }

    public function getJoinSQL()
    {
        return <<<SQL
LEFT JOIN (
  SELECT pid AS patientid, MAX(id) AS max_id
  FROM dental_flow_pg1
  GROUP BY pid
) rx_lomn_pivot ON rx_lomn_pivot.patientid = p.patientid
LEFT JOIN dental_flow_pg1 rx_lomn ON rx_lomn.id = rx_lomn_pivot.max_id
SQL;
    }

    protected function getInnerOrderSQL($dir)
    {
        return <<<SQL
rx_lomn $dir
SQL;
    }
}
