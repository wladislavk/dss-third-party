<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

class LedgerSection extends AbstractAdvanceOrderingSection
{
    public function getSelectSQL()
    {
        return <<<SQL
(
  COALESCE(
    (
      SELECT SUM(COALESCE(first.amount, 0)) AS total
      FROM dental_ledger first
      WHERE first.docid = p.docid
      AND first.patientid = p.patientid
      AND COALESCE(first.paid_amount, 0) = 0
    ), 0
  )
  + COALESCE(
    (
      SELECT SUM(COALESCE(second.amount, 0)) - SUM(COALESCE(second.paid_amount, 0))
      FROM dental_ledger second
      WHERE second.docid = p.docid
      AND second.patientid = p.patientid
      AND second.paid_amount != 0
    ), 0
  )
  - COALESCE(
    (
      SELECT SUM(COALESCE(third_payment.amount, 0))
      FROM dental_ledger third
      LEFT JOIN dental_ledger_payment third_payment ON third_payment.ledgerid = third.ledgerid
      WHERE third.docid = p.docid
      AND third.patientid = p.patientid
      AND third_payment.amount != 0
    ), 0
  )
) AS total
SQL;
    }

    public function getJoinSQL()
    {
        return '';
    }

    protected function getInnerOrderSQL($dir)
    {
        return <<<SQL
ledger IS NOT NULL $dir, total $dir
SQL;
    }
}
