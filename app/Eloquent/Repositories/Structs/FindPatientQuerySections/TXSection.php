<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Structs\FindPatientQuerySections;

use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;

class TXSection extends AbstractAdvanceOrderingSection
{
    public function getSelectSQL()
    {
        $userTypeSoftware = PatientRepository::USER_TYPE_SOFTWARE;
        // @todo: integer cannot be aliased
        return <<<SQL
(
  (
    '%COLUMN%' = '$userTypeSoftware'
    AND COALESCE(p.p_m_dss_file, 0) != 0
  )
  OR COALESCE(p.p_m_dss_file, 0) = 1
) AS insurance_no_error,
(
  SELECT COUNT(id)
  FROM dental_summ_sleeplab sleep_lab
  WHERE sleep_lab.patiendid = p.patientid
  AND COALESCE(sleep_lab.filename, '') != ''
  AND COALESCE(sleep_lab.diagnosis, '') != ''
  AND (
    p.p_m_ins_type != '1'
    OR (
      COALESCE(sleep_lab.diagnosising_doc, '') != ''
      AND COALESCE(sleep_lab.diagnosising_npi, '') != ''
    )
  )
) AS numsleepstudy
SQL;
    }

    public function getJoinSQL()
    {
        return '';
    }

    protected function getInnerOrderSQL($dir)
    {
        return <<<SQL
(insurance_no_error AND numsleepstudy > 0) $dir
SQL;
    }
}
